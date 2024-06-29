<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Kehadiran extends Model
{
    use HasFactory;
    protected $table = "kehadiran";

    protected $guarded =[];
    public $timestamps = true;
    public function user()
    {
        return $this->belongsTo(User::class,'user_id','id');
    }
}
