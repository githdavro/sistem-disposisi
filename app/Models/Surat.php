<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Surat extends Model
{
    use HasFactory;
    
    protected $table = 'surat'; // Tambahkan baris ini
    
    protected $fillable = [
        'pengirim_id',
        'unit_tujuan_id',
        'file',
        'catatan',
        'sifat',
        'nominal',
        'status',
    ];
    
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
}