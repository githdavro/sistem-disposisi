<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Surat;
use App\Models\Notifikasi;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        if ($user->hasRole('Admin')) {
            return $this->adminDashboard();
        } elseif ($user->hasRole('Unit')) {
            return $this->unitDashboard();
        } elseif ($user->hasRole('Pengadaan')) {
            return $this->pengadaanDashboard();
        } elseif ($user->hasRole('Direktur')) {
            return $this->direkturDashboard();
        }
        
        return redirect()->route('login');
    }
    
    private function adminDashboard()
    {
        $totalSurat = Surat::count();
        $suratDisetujui = Surat::where('status', 'Disetujui')->count();
        $suratDitolak = Surat::where('status', 'Ditolak')->count();
        $suratMenunggu = Surat::where('status', 'Menunggu')->count();
        
        // Statistik per unit
        $statistikPerUnit = \App\Models\Unit::withCount('suratTujuan')->get();
        
        return view('dashboard.admin', compact(
            'totalSurat',
            'suratDisetujui',
            'suratDitolak',
            'suratMenunggu',
            'statistikPerUnit'
        ));
    }
    
    private function unitDashboard()
    {
        $user = Auth::user();
        $suratTerkirim = Surat::where('pengirim_id', $user->id)->get();
        $suratMasuk = Surat::where('unit_tujuan_id', $user->unit_id)->get();
        $notifikasi = Notifikasi::where('user_id', $user->id)->where('dibaca', false)->get();
        
        return view('dashboard.unit', compact(
            'suratTerkirim',
            'suratMasuk',
            'notifikasi'
        ));
    }
    
    private function pengadaanDashboard()
    {
        $suratMasuk = Surat::where('status', 'Menunggu')->get();
        $suratMenungguApproval = Surat::where('status', 'Diproses')->get();
        $suratSelesai = Surat::where('status', 'Selesai')->get();
        
        return view('dashboard.pengadaan', compact(
            'suratMasuk',
            'suratMenungguApproval',
            'suratSelesai'
        ));
    }
    
    private function direkturDashboard()
    {
        $suratMenungguApproval = Surat::whereHas('approval', function ($query) {
            $query->where('status', 'Menunggu');
        })->get();
        
        $riwayatKeputusan = Surat::whereHas('approval', function ($query) {
            $query->where('status', '!=', 'Menunggu');
        })->get();
        
        return view('dashboard.direktur', compact(
            'suratMenungguApproval',
            'riwayatKeputusan'
        ));
    }
}