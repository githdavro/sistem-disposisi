<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Unit extends Model
{
    use HasFactory;
    
    protected $table = 'unit'; // Tambahkan baris ini
    
    protected $fillable = [
        'nama_unit',
    ];
    
    public function user()
    {
        return $this->hasMany(User::class);
    }
    
    public function suratTujuan()
    {
        return $this->hasMany(Surat::class, 'unit_tujuan_id');
    }
}