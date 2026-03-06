<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\Surat;
use App\Models\Disposisi;
use App\Models\Approval;
use App\Models\Notifikasi;
use App\Models\Unit;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class SuratController extends Controller
{
    public function index(Request $request)
{
    $user = Auth::user();
    
    // Ambil semua parameter filter
    $status = $request->get('status');
    $sifat = $request->get('sifat');
    $sort = $request->get('sort', 'desc');
    $search = $request->get('search'); // Identitas (Nomor Surat)
    $unit = $request->get('unit');     // Asal/Tujuan
    $min_nominal = $request->get('min_nominal');
    $max_nominal = $request->get('max_nominal');
    $date_from = $request->get('date_from');
    $date_to = $request->get('date_to');

    $query = Surat::with(['pengirim', 'unitTujuan']);

    // 1. Filter Berdasarkan Role (Existing)
    if ($user->hasRole('Admin') || $user->hasRole('Pengadaan')) {
        // Full akses
    } elseif ($user->hasRole('Unit')) {
        $query->where(function($q) use ($user) {
            $q->where('pengirim_id', $user->id)
              ->orWhere('unit_tujuan_id', $user->unit_id);
        });
    } elseif ($user->hasRole('Direktur')) {
        $query->whereHas('approval', function ($q) {
            $q->where('approver_id', Auth::id());
        });
    }

    // 2. Filter Dinamis Baru
    $query->when($status, fn($q) => $q->where('status', $status))
          ->when($sifat, fn($q) => $q->where('sifat', $sifat))
          ->when($search, fn($q) => $q->where('nomor_surat', 'like', "%{$search}%"))
          ->when($unit, function($q) use ($unit) {
              $q->whereHas('unitTujuan', fn($sq) => $sq->where('nama_unit', 'like', "%{$unit}%"))
                ->orWhereHas('pengirim', fn($sq) => $sq->where('name', 'like', "%{$unit}%"));
          })
          ->when($min_nominal, fn($q) => $q->where('nominal', '>=', $min_nominal))
          ->when($max_nominal, fn($q) => $q->where('nominal', '<=', $max_nominal))
          ->when($date_from, fn($q) => $q->whereDate('created_at', '>=', $date_from))
          ->when($date_to, fn($q) => $q->whereDate('created_at', '<=', $date_to));

    // 3. Sorting & Pagination
    $surat = $query->orderBy('created_at', $sort)->paginate(10);

    return view('surat.index', compact('surat'));
}
    
    public function create()
    {
        $unit = Unit::all();
        return view('surat.create', compact('unit'));
    }
    
    public function store(Request $request)
{
    // VALIDASI
    $request->validate([
        'unit_tujuan_id' => 'required|exists:unit,id',
        'file' => 'nullable|file|mimes:pdf,doc,docx|max:2048',
        'catatan' => 'nullable|string',
        'sifat' => 'required|in:Rahasia,Penting,Disegerakan',
        'nominal' => 'required|numeric|min:0',
    ]);

    $user = Auth::user();

    $fileName = null;

    // UPLOAD FILE JIKA ADA
    if ($request->hasFile('file')) {

        $file = $request->file('file');

        $fileName = time() . '_' . Str::random(10) . '.' . $file->getClientOriginalExtension();

        Storage::disk('public')->putFileAs('surat', $file, $fileName);
    }

    // CREATE SURAT
    $surat = Surat::create([
        'pengirim_id' => $user->id,
        'unit_tujuan_id' => $request->unit_tujuan_id,
        'file' => $fileName,
        'catatan' => $request->catatan,
        'sifat' => $request->sifat,
        'nominal' => $request->nominal,
        'status' => 'Menunggu',
    ]);

    // LOGIKA APPROVAL
    if ($request->nominal > 1000000) {

        $direktur = User::role('Direktur')->first();

        if ($direktur) {

            Approval::create([
                'surat_id' => $surat->id,
                'approver_id' => $direktur->id,
                'status' => 'Menunggu',
            ]);

            $surat->update(['status' => 'Diproses']);

            Notifikasi::create([
                'user_id' => $direktur->id,
                'surat_id' => $surat->id,
                'judul' => 'Surat Menunggu Approval',
                'pesan' => 'Ada surat yang menunggu approval Anda dengan nominal lebih dari 1 juta.',
            ]);
        }

    } else {

        $pengadaan = User::role('Pengadaan')->first();

        if ($pengadaan) {

            Notifikasi::create([
                'user_id' => $pengadaan->id,
                'surat_id' => $surat->id,
                'judul' => 'Surat Baru Masuk',
                'pesan' => 'Ada surat baru yang perlu diproses.',
            ]);
        }
    }

    return redirect()->route('surat.index')
        ->with('success', 'Surat berhasil dikirim dengan nomor: ' . $surat->nomor_surat);
}
    public function show($id)
    {
        $surat = Surat::with(['pengirim', 'unitTujuan', 'approval', 'disposisi'])->findOrFail($id);
        
        // Mark notification as read if exists
        $notifikasi = Notifikasi::where('user_id', Auth::id())
            ->where('surat_id', $id)
            ->where('dibaca', false)
            ->first();
            
        if ($notifikasi) {
            $notifikasi->dibaca = true;
            $notifikasi->save();
        }
        
        return view('surat.show', compact('surat'));
    }
    
    public function edit($id)
    {
        $surat = Surat::findOrFail($id);
        $unit = Unit::all();
        
        // Check if user can edit this surat
        $user = Auth::user();
        if (!$user->hasRole('Admin') && $surat->pengirim_id != $user->id) {
            return redirect()->route('surat.index')
                ->with('error', 'Anda tidak memiliki izin untuk mengedit surat ini.');
        }
        
        return view('surat.edit', compact('surat', 'unit'));
    }
    
    public function update(Request $request, $id)
    {
        $request->validate([
            'unit_tujuan_id' => 'required|exists:unit,id',
            'catatan' => 'nullable|string',
            'sifat' => 'required|in:Rahasia,Penting,Disegerakan',
            'nominal' => 'required|numeric|min:0',
        ]);
        
        $surat = Surat::findOrFail($id);
        
        // Check if user can edit this surat
        $user = Auth::user();
        if (!$user->hasRole('Admin') && $surat->pengirim_id != $user->id) {
            return redirect()->route('surat.index')
                ->with('error', 'Anda tidak memiliki izin untuk mengedit surat ini.');
        }
        
        // Update surat
        $surat->update([
            'unit_tujuan_id' => $request->unit_tujuan_id,
            'catatan' => $request->catatan,
            'sifat' => $request->sifat,
            'nominal' => $request->nominal,
        ]);
        
        // Upload new file if provided
        if ($request->hasFile('file')) {
            $request->validate([
                'file' => 'mimes:pdf,doc,docx|max:2048',
            ]);
            
            // Delete old file
            Storage::delete('public/surat/' . $surat->file);
            
            // Upload new file
            $file = $request->file('file');
            $fileName = time() . '_' . Str::random(10) . '.' . $file->getClientOriginalExtension();
            Storage::disk('public')->putFileAs('surat', $file, $fileName);

            
            $surat->file = $fileName;
            $surat->save();
        }
        
        return redirect()->route('surat.index')
            ->with('success', 'Surat berhasil diperbarui.');
    }
    
    public function destroy($id)
    {
        $surat = Surat::findOrFail($id);
        
        // Check if user can delete this surat
        $user = Auth::user();
        if (!$user->hasRole('Admin') && $surat->pengirim_id != $user->id) {
            return redirect()->route('surat.index')
                ->with('error', 'Anda tidak memiliki izin untuk menghapus surat ini.');
        }
        
        // Delete file
        Storage::delete('public/surat/' . $surat->file);
        
        // Delete surat
        $surat->delete();
        
        return redirect()->route('surat.index')
            ->with('success', 'Surat berhasil dihapus.');
    }
    
    public function proses($id)
    {
        $surat = Surat::findOrFail($id);
        
        // Check if user is Pengadaan
        if (!Auth::user()->hasRole('Pengadaan')) {
            return redirect()->route('surat.index')
                ->with('error', 'Anda tidak memiliki izin untuk memproses surat ini.');
        }
        
        // Update surat status
        $surat->status = 'Diproses';
        $surat->save();
        
        // Create notification for Direktur if needed
        if ($surat->nominal > 1000000) {
            $direktur = \App\Models\User::role('Direktur')->first();
            
            // Check if approval already exists
            $approval = Approval::where('surat_id', $surat->id)->first();
            
            if (!$approval) {
                Approval::create([
                    'surat_id' => $surat->id,
                    'approver_id' => $direktur->id,
                    'status' => 'Menunggu',
                ]);
                
                Notifikasi::create([
                    'user_id' => $direktur->id,
                    'surat_id' => $surat->id,
                    'judul' => 'Surat Menunggu Approval',
                    'pesan' => 'Ada surat yang menunggu approval Anda dengan nominal lebih dari 1 juta.',
                ]);
            }
        } else {
            // If nominal <= 1 juta, directly process
            $surat->status = 'Selesai';
            $surat->save();
            
            // Create notification for unit tujuan
            if ($surat->unit_tujuan_id) {
                $unitTujuan = \App\Models\Unit::findOrFail($surat->unit_tujuan_id);
                $usersUnit = \App\Models\User::where('unit_id', $unitTujuan->id)->get();
                
                foreach ($usersUnit as $user) {
                    Notifikasi::create([
                        'user_id' => $user->id,
                        'surat_id' => $surat->id,
                        'judul' => 'Surat Baru',
                        'pesan' => 'Anda menerima surat baru.',
                    ]);
                }
            }
        }
        
        return redirect()->route('surat.show', $id)
            ->with('success', 'Surat berhasil diproses.');
    }
    
    public function kirimKeUnit($id)
    {
        $surat = Surat::findOrFail($id);
        
        // Check if user is Pengadaan
        if (!Auth::user()->hasRole('Pengadaan')) {
            return redirect()->route('surat.index')
                ->with('error', 'Anda tidak memiliki izin untuk mengirim surat ini.');
        }
        
        // Check if surat is approved by Direktur
        if ($surat->nominal > 1000000) {
            $approval = Approval::where('surat_id', $surat->id)
                ->where('status', 'Disetujui')
                ->first();
                
            if (!$approval) {
                return redirect()->route('surat.show', $id)
                    ->with('error', 'Surat belum disetujui oleh Direktur.');
            }
        }
        
        // Update surat status
        $surat->status = 'Selesai';
        $surat->save();
        
        // Create notification for unit tujuan
        if ($surat->unit_tujuan_id) {
            $unitTujuan = \App\Models\Unit::findOrFail($surat->unit_tujuan_id);
            $usersUnit = \App\Models\User::where('unit_id', $unitTujuan->id)->get();
            
            foreach ($usersUnit as $user) {
                Notifikasi::create([
                    'user_id' => $user->id,
                    'surat_id' => $surat->id,
                    'judul' => 'Surat Baru',
                    'pesan' => 'Anda menerima surat baru.',
                ]);
            }
        }
        
        // Create notification for pengirim
        Notifikasi::create([
            'user_id' => $surat->pengirim_id,
            'surat_id' => $surat->id,
            'judul' => 'Surat Diproses',
            'pesan' => 'Surat Anda telah diproses dan dikirim ke unit tujuan.',
        ]);
        
        return redirect()->route('surat.show', $id)
            ->with('success', 'Surat berhasil dikirim ke unit tujuan.');
    }

    public function lampiran(Request $request)
{
    $user = Auth::user();
    
    $query = Surat::with(['pengirim.unit', 'unitTujuan'])
        ->whereNotNull('file') // Hanya surat yang memiliki lampiran
        ->orderBy('created_at', 'desc');
    
    // Filter berdasarkan role
    if (!$user->hasRole('Admin') && !$user->hasRole('Pengadaan')) {
        if ($user->hasRole('Unit')) {
            $query->where(function($q) use ($user) {
                $q->where('pengirim_id', $user->id)
                  ->orWhere('unit_tujuan_id', $user->unit_id);
            });
        } elseif ($user->hasRole('Direktur')) {
            $query->whereHas('approval', function($q) use ($user) {
                $q->where('approver_id', $user->id);
            });
        }
    }
    
    // Filter pencarian
    if ($request->filled('search')) {
        $search = $request->search;
        $query->where(function($q) use ($search) {
            $q->where('file', 'like', "%{$search}%")
              ->orWhere('catatan', 'like', "%{$search}%")
              ->orWhereHas('pengirim', function($sq) use ($search) {
                  $sq->where('name', 'like', "%{$search}%");
              });
        });
    }
    
    // Filter unit pengirim
    if ($request->filled('unit_pengirim')) {
        $query->whereHas('pengirim', function($q) use ($request) {
            $q->where('unit_id', $request->unit_pengirim);
        });
    }
    
    // Filter unit tujuan
    if ($request->filled('unit_tujuan')) {
        $query->where('unit_tujuan_id', $request->unit_tujuan);
    }
    
    // Filter periode
    if ($request->filled('periode')) {
        $now = now();
        switch($request->periode) {
            case 'hari':
                $query->whereDate('created_at', $now->toDateString());
                break;
            case 'minggu':
                $query->whereBetween('created_at', [$now->startOfWeek(), $now->endOfWeek()]);
                break;
            case 'bulan':
                $query->whereMonth('created_at', $now->month)
                      ->whereYear('created_at', $now->year);
                break;
            case 'tahun':
                $query->whereYear('created_at', $now->year);
                break;
        }
    }
    
    $surat = $query->paginate(15);
    
    // Data untuk statistik
    $totalSurat = Surat::count();
    $totalLampiran = Surat::whereNotNull('file')->count();
    $suratBulanIni = Surat::whereMonth('created_at', now()->month)
                          ->whereYear('created_at', now()->year)
                          ->count();
    
    $units = Unit::all();
    
    return view('surat.lampiran', compact('surat', 'units', 'totalSurat', 'totalLampiran', 'suratBulanIni'));
}
}