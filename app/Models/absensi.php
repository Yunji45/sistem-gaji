<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class absensi extends Model
{
    use HasFactory;
    protected $table = 'absensis';
    protected $primaryKey = 'id';
    protected $fillable = [
        'user_id', 
        'status_presensi',
        'check_in', 
        'check_out', 
        'latitude', 
        'longitude',
        'deskripsi'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
}
