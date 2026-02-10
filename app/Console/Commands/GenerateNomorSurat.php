<?php

namespace App\Console\Commands;

use App\Models\Surat;
use App\Models\Unit;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class GenerateNomorSurat extends Command
{
    protected $signature = 'surat:generate-nomor';
    protected $description = 'Generate nomor surat untuk data existing';

    public function handle()
    {
        $this->info("Memulai proses generate nomor surat...");
        
        // Ambil semua surat yang belum memiliki nomor surat
        $surats = Surat::whereNull('nomor_surat')->get();
        
        $this->info("Men-generate nomor surat untuk {$surats->count()} surat...");
        
        if ($surats->count() === 0) {
            $this->info("Tidak ada surat yang perlu digenerate.");
            return Command::SUCCESS;
        }
        
        $bar = $this->output->createProgressBar($surats->count());
        
        foreach ($surats as $surat) {
            try {
                // Generate nomor surat dengan method yang sudah diperbaiki
                $nomorSurat = $this->generateNomorSuratForExisting($surat);
                
                // Update dengan transaction
                DB::transaction(function () use ($surat, $nomorSurat) {
                    $surat->update(['nomor_surat' => $nomorSurat]);
                });
                
                $bar->advance();
            } catch (\Exception $e) {
                $this->error("Error pada surat ID {$surat->id}: " . $e->getMessage());
                continue;
            }
        }
        
        $bar->finish();
        $this->info("\nSelesai!");
        
        return Command::SUCCESS;
    }
    
    /**
     * Generate nomor surat untuk data existing dengan cara yang aman
     */
    private function generateNomorSuratForExisting(Surat $surat)
    {
        $now = $surat->created_at;
        $tahun = $now->year;
        $bulan = $now->format('m');
        
        // Mapping kode surat berdasarkan sifat
        $kodeSuratMap = [
            'Rahasia' => 'RHS',
            'Penting' => 'PNT',
            'Disegerakan' => 'DSG'
        ];
        
        // Ambil kode surat dari sifat
        $kodeSurat = $kodeSuratMap[$surat->sifat] ?? 'UND';
        
        // Ambil kode unit
        $kodeUnit = 'PENG'; // Default untuk pengadaan
        if ($surat->unit_tujuan_id) {
            $unit = Unit::find($surat->unit_tujuan_id);
            if ($unit && $unit->kode_unit) {
                $kodeUnit = $unit->kode_unit;
            }
        }
        
        // Cari nomor urut yang belum digunakan
        $nomorUrut = 1;
        $maxAttempts = 1000; // Maksimal percobaan
        
        for ($i = 0; $i < $maxAttempts; $i++) {
            $nomorSurat = sprintf(
                '%03d/%s/%s/SISTEM/%s/%s',
                $nomorUrut,
                $kodeSurat,
                $kodeUnit,
                $bulan,
                $tahun
            );
            
            // Cek apakah nomor surat sudah ada
            $exists = Surat::where('nomor_surat', $nomorSurat)->exists();
            
            if (!$exists) {
                return $nomorSurat;
            }
            
            $nomorUrut++;
        }
        
        // Jika masih duplicate, tambahkan timestamp untuk membuat unique
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