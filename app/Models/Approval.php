<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Approval extends Model
{
    use HasFactory;
    
    protected $table = 'approval'; // Tambahkan baris ini
    
    protected $fillable = [
        'surat_id',
        'approver_id',
        'status',
        'catatan',
        'file_catatan',
    ];
    
    public function surat()
    {
        return $this->belongsTo(Surat::class);
    }
    
    public function approver()
    {
        return $this->belongsTo(User::class, 'approver_id');
    }
}