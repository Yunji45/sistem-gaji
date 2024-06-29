<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KelolaSalary extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $table = "kelola_salary";
    public $timestamps = true;
}
