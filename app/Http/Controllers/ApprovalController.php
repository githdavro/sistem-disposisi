<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Surat;
use App\Models\Approval;
use App\Models\Notifikasi;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ApprovalController extends Controller
{
    public function approve(Request $request, $id)
    {
        $request->validate([
            'catatan' => 'nullable|string',
            'file_catatan' => 'nullable|mimes:pdf,doc,docx,jpg,jpeg,png|max:2048',
        ]);
        
        $surat = Surat::findOrFail($id);
        $user = Auth::user();
        
        // Check if user is Direktur
        if (!$user->hasRole('Direktur')) {
            return redirect()->route('surat.show', $id)
                ->with('error', 'Anda tidak memiliki izin untuk menyetujui surat ini.');
        }
        
        // Find approval
        $approval = Approval::where('surat_id', $id)
            ->where('approver_id', $user->id)
            ->firstOrFail();
        
        // Update approval
        $approval->status = 'Disetujui';
        $approval->catatan = $request->catatan;
        
        // Upload file if provided
        if ($request->hasFile('file_catatan')) {
            $file = $request->file('file_catatan');
            $fileName = time() . '_' . Str::random(10) . '.' . $file->getClientOriginalExtension();
            $file->storeAs('public/approval', $fileName);
            $approval->file_catatan = $fileName;
        }
        
        $approval->save();
        
        // Update surat status
        $surat->status = 'Disetujui';
        $surat->save();
        
        // Create notification for Pengadaan
        $pengadaan = \App\Models\User::role('Pengadaan')->first();
        
        Notifikasi::create([
            'user_id' => $pengadaan->id,
            'surat_id' => $surat->id,
            'judul' => 'Surat Disetujui',
            'pesan' => 'Surat telah disetujui oleh Direktur dan dapat dikirim ke unit tujuan.',
        ]);
        
        return redirect()->route('surat.show', $id)
            ->with('success', 'Surat berhasil disetujui.');
    }
    
    public function reject(Request $request, $id)
    {
        $request->validate([
            'catatan' => 'required|string',
            'file_catatan' => 'nullable|mimes:pdf,doc,docx,jpg,jpeg,png|max:2048',
        ]);
        
        $surat = Surat::findOrFail($id);
        $user = Auth::user();
        
        // Check if user is Direktur
        if (!$user->hasRole('Direktur')) {
            return redirect()->route('surat.show', $id)
                ->with('error', 'Anda tidak memiliki izin untuk menolak surat ini.');
        }
        
        // Find approval
        $approval = Approval::where('surat_id', $id)
            ->where('approver_id', $user->id)
            ->firstOrFail();
        
        // Update approval
        $approval->status = 'Ditolak';
        $approval->catatan = $request->catatan;
        
        // Upload file if provided
        if ($request->hasFile('file_catatan')) {
            $file = $request->file('file_catatan');
            $fileName = time() . '_' . Str::random(10) . '.' . $file->getClientOriginalExtension();
            $file->storeAs('public/approval', $fileName);
            $approval->file_catatan = $fileName;
        }
        
        $approval->save();
        
        // Update surat status
        $surat->status = 'Ditolak';
        $surat->save();
        
        // Create notification for Pengadaan
        $pengadaan = \App\Models\User::role('Pengadaan')->first();
        
        Notifikasi::create([
            'user_id' => $pengadaan->id,
            'surat_id' => $surat->id,
            'judul' => 'Surat Ditolak',
            'pesan' => 'Surat telah ditolak oleh Direktur.',
        ]);
        
        // Create notification for pengirim
        Notifikasi::create([
            'user_id' => $surat->pengirim_id,
            'surat_id' => $surat->id,
            'judul' => 'Surat Ditolak',
            'pesan' => 'Surat Anda telah ditolak oleh Direktur.',
        ]);
        
        return redirect()->route('surat.show', $id)
            ->with('success', 'Surat berhasil ditolak.');
    }
}