<?php

namespace Database\Seeders;

use App\Models\SetBulan;
use Illuminate\Database\Seeder;

class SetBulanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        SetBulan::create(['bulan' => 'January']);
        SetBulan::create(['bulan' => 'February']);
        SetBulan::create(['bulan' => 'March']);
        SetBulan::create(['bulan' => 'April']);
        SetBulan::create(['bulan' => 'May']);
        SetBulan::create(['bulan' => 'June']);
        SetBulan::create(['bulan' => 'July']);
        SetBulan::create(['bulan' => 'August']);
        SetBulan::create(['bulan' => 'September']);
        SetBulan::create(['bulan' => 'October']);
        SetBulan::create(['bulan' => 'November']);
        SetBulan::create(['bulan' => 'December']);
    }
}
