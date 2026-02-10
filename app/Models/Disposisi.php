<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Disposisi extends Model
{
    use HasFactory;
    
    protected $table = 'disposisi'; // Tambahkan baris ini
    
    protected $fillable = [
        'surat_id',
        'pengirim_id',
        'penerima_id',
        'catatan',
        'status',
    ];
    
    public function surat()
    {
        return $this->belongsTo(Surat::class);
    }
    
    public function pengirim()
    {
        return $this->belongsTo(User::class, 'pengirim_id');
    }
    
    public function penerima()
    {
        return $this->belongsTo(User::class, 'penerima_id');
    }
}