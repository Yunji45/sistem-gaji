<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Salary;
use App\Models\Kehadiran;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Database\Seeders\SetBulanSeeder;
use Spatie\Permission\Models\Permission;
use Database\Seeders\PermissionDemoSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            PermissionDemoSeeder::class,
            SetBulanSeeder::class
        ]);
        $pt = ['PT_SMK','PT_AEI'];
        for ($i = 0; $i < 20; $i++) {
            $user = User::factory()->create()->assignRole('karyawan')->givePermissionTo($pt[array_rand($pt,1)]);
            // ->syncPermissions(array_rand($pt,1));
            Kehadiran::factory()
                ->count(90)
                ->for($user)
                ->create();
        }
    }
}
