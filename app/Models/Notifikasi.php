<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notifikasi extends Model
{
    use HasFactory;
    
    protected $table = 'notifikasi'; // Tambahkan baris ini
    
    protected $fillable = [
        'user_id',
        'surat_id',
        'judul',
        'pesan',
        'dibaca',
    ];
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    public function surat()
    {
        return $this->belongsTo(Surat::class);
    }
}