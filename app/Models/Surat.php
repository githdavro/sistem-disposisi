<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Surat extends Model
{
    use HasFactory;
    
    protected $table = 'surat';
    
    protected $fillable = [
        'nomor_surat',
        'pengirim_id',
        'unit_tujuan_id',
        'file',
        'catatan',
        'sifat',
        'nominal',
        'status',
    ];
    
    // Mapping kode surat berdasarkan sifat
    private static $kodeSuratMap = [
        'Rahasia' => 'RHS',
        'Penting' => 'PNT',
        'Disegerakan' => 'DSG'
    ];
    
    // Kode sistem
    const KODE_SISTEM = 'SISTEM';
    
    // Event untuk auto-generate nomor surat saat create
    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($surat) {
            if (empty($surat->nomor_surat)) {
                $surat->nomor_surat = self::generateNomorSurat($surat->sifat, $surat->unit_tujuan_id);
            }
        });
    }
    
    public function pengirim()
    {
        return $this->belongsTo(User::class, 'pengirim_id');
    }
    
    public function unitTujuan()
    {
        return $this->belongsTo(Unit::class, 'unit_tujuan_id');
    }
    
    public function approval()
    {
        return $this->hasMany(Approval::class);
    }
    
    public function disposisi()
    {
        return $this->hasMany(Disposisi::class);
    }
    
    /**
     * Generate nomor surat otomatis
     * Format: NomorUrut/KodeSurat/KodeUnit/KodeSistem/Bulan/Tahun
     */
    public static function generateNomorSurat($sifat, $unitTujuanId = null)
{
    $now = now();
    $tahun = $now->year;
    $bulan = $now->format('m');
    
    $kodeSuratMap = [
        'Rahasia' => 'RHS',
        'Penting' => 'PNT', 
        'Disegerakan' => 'DSG'
    ];
    
    $kodeSurat = $kodeSuratMap[$sifat] ?? 'UND';
    
    $kodeUnit = 'PENG';
    if ($unitTujuanId) {
        $unit = \App\Models\Unit::find($unitTujuanId);
        if ($unit && $unit->kode_unit) {
            $kodeUnit = $unit->kode_unit;
        }
    }
    
    // Hitung berapa surat bulan ini
    $count = self::whereYear('created_at', $tahun)
        ->whereMonth('created_at', $bulan)
        ->count();
    
    $nomorUrut = $count + 1;
    
    // Coba hingga 100 kali
    for ($i = 0; $i < 100; $i++) {
        $nomorSurat = sprintf(
            '%03d/%s/%s/SISTEM/%s/%s',
            $nomorUrut,
            $kodeSurat,
            $kodeUnit,
            $bulan,
            $tahun
        );
        
        if (!self::where('nomor_surat', $nomorSurat)->exists()) {
            return $nomorSurat;
        }
        
        $nomorUrut++;
    }
    
    // Jika masih duplikat, tambah timestamp
    return sprintf(
        '%03d/%s/%s/SISTEM/%s/%s-%d',
        $nomorUrut,
        $kodeSurat,
        $kodeUnit,
        $bulan,
        $tahun,
        time()
    );
}
}