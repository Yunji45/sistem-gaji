<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class SalaryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => 'Gaji Bulan Mei',
            'total_kehadiran' => $this->faker->randomElement([22,20,18]),
            'salary_karyawan' => $this->faker->randomElement([4000000,3700000,3300000]),
        ];
    }
}
