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
    public function index()
{
    $user = Auth::user();
    
    if ($user->hasRole('Admin')) {
        $surat = Surat::with(['pengirim', 'unitTujuan'])->paginate(10);
    } elseif ($user->hasRole('Unit')) {
        $surat = Surat::where(function($query) use ($user) {
            $query->where('pengirim_id', $user->id)
                  ->orWhere('unit_tujuan_id', $user->unit_id);
        })->with(['pengirim', 'unitTujuan'])->paginate(10);
    } elseif ($user->hasRole('Pengadaan')) {
        $surat = Surat::with(['pengirim', 'unitTujuan'])->paginate(perPage: 10);
    } elseif ($user->hasRole('Direktur')) {
        $surat = Surat::whereHas('approval', function ($query) {
            $query->where('approver_id', Auth::id());
        })->with(['pengirim', 'unitTujuan'])->paginate(10);
    }
    
    return view('surat.index', compact('surat'));
}
    
    public function create()
    {
        $unit = Unit::all();
        return view('surat.create', compact('unit'));
    }
    
    public function store(Request $request)
{
    // 1️⃣ VALIDASI
    $request->validate([
        'unit_tujuan_id' => 'required|exists:unit,id',
        'file' => 'required|file|mimes:pdf,doc,docx|max:2048',
        'catatan' => 'nullable|string',
        'sifat' => 'required|in:Rahasia,Penting,Disegerakan',
        'nominal' => 'required|numeric|min:0',
    ]);

    // 2️⃣ CEK FILE
    if (!$request->hasFile('file')) {
        return back()
            ->withErrors(['file' => 'File surat wajib diupload'])
            ->withInput();
    }

    $user = Auth::user();

    // 3️⃣ UPLOAD FILE
    $file = $request->file('file');
    $fileName = time() . '_' . Str::random(10) . '.' . $file->getClientOriginalExtension();
    Storage::disk('public')->putFileAs('surat', $file, $fileName);

    // 4️⃣ CREATE SURAT (nomor surat akan otomatis digenerate oleh event)
    $surat = Surat::create([
        'pengirim_id' => $user->id,
        'unit_tujuan_id' => $request->unit_tujuan_id,
        'file' => $fileName,
        'catatan' => $request->catatan,
        'sifat' => $request->sifat,
        'nominal' => $request->nominal,
        'status' => 'Menunggu',
    ]);

    // 5️⃣ LOGIKA APPROVAL
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
}