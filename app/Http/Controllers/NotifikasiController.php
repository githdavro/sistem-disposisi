<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Notifikasi;
use Illuminate\Support\Facades\Auth;

class NotifikasiController extends Controller
{
    public function index()
    {
        $notifikasi = Notifikasi::where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();
            
        return view('notifikasi.index', compact('notifikasi'));
    }
    
    public function show($id)
    {
        $notifikasi = Notifikasi::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();
            
        // Mark as read
        $notifikasi->dibaca = true;
        $notifikasi->save();
        
        return view('notifikasi.show', compact('notifikasi'));
    }
    
    public function markAsRead($id)
    {
        $notifikasi = Notifikasi::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();
            
        $notifikasi->dibaca = true;
        $notifikasi->save();
        
        return redirect()->back()
            ->with('success', 'Notifikasi ditandai sebagai telah dibaca.');
    }
    
    public function markAllAsRead()
    {
        Notifikasi::where('user_id', Auth::id())
            ->where('dibaca', false)
            ->update(['dibaca' => true]);
            
        return redirect()->back()
            ->with('success', 'Semua notifikasi ditandai sebagai telah dibaca.');
    }
}