<?php

namespace Database\Factories;

use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

class KehadiranFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function getKehadiran()
    {
        return $this->faker->randomElement(['hadir', 'izin', 'cuti','pulang']);
    }
    public function waktuPresensi($status)
    {
        $this->status = $status;
        switch($status){
            case "hadir":
                $date = date_parse(new Carbon(Carbon::today()->subDays(rand(180, 210))));
                $date['hour'] = 07;
                $date['minute'] = 20;
                $date['year'] = 2023;
                $date['month'] = $this->faker->randomElement([4,5,6]);
                return $date['year'].'-'.$date['month'].'-'.$date['day'].' '.$date['hour'].':'.$date['minute'].':'.$date['second'];
                break;
            case "izin":
                $date = date_parse(new Carbon(Carbon::today()->subDays(rand(180, 210))));
                $date['year'] = 2023;
                $date['month'] = $this->faker->randomElement([4,5,6]);
                return $date['year'].'-'.$date['month'].'-'.$date['day'].' '.$date['hour'].':'.$date['minute'].':'.$date['second'];
                break;
            case "cuti":
                $date = date_parse(new Carbon(Carbon::today()->subDays(rand(180, 210))));
                $date['year'] = 2023;
                $date['month'] = $this->faker->randomElement([4,5,6]);
                return $date['year'].'-'.$date['month'].'-'.$date['day'].' '.$date['hour'].':'.$date['minute'].':'.$date['second'];
                break;
            case "pulang":
                $date = date_parse(new Carbon(Carbon::today()->subDays(rand(180, 210))));
                $date['hour'] = 16;
                $date['minute'] = 20;
                $date['year'] = 2023;
                $date['month'] = $this->faker->randomElement([4,5,6]);
                return $date['year'].'-'.$date['month'].'-'.$date['day'].' '.$date['hour'].':'.$date['minute'].':'.$date['second'];
                break;
        }
    }
    public function deskripsi($kehadiran)
    {
        switch($kehadiran){
            case "hadir":
                return "bekerja di kantor";
                break;
            case "izin":
                return "karena urusan pribadi";
                break;
            case "cuti":
                return "acara keluarga";
                break;
            case "pulang":
                return "pulang di kantor";
                break;
        }
    }
    public function definition()
    {
        $kehadiran =  $this->faker->randomElement(['hadir', 'izin', 'cuti','pulang']);
        return [
            'status_presensi' => $kehadiran,
            'waktu_presensi' => $this->waktuPresensi($kehadiran),
            'deskripsi' => $this->deskripsi($kehadiran)
        ];
    }
}
