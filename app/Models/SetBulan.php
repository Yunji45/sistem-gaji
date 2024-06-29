<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SetBulan extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'set_bulan';
    protected $guarded = [];
}
