<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;

class PermissionDemoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // reset cahced roles and permission
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // create permissions
        Permission::create(['name' => 'dashboard_user']);
        Permission::create(['name' => 'dashboard_admin']);
        Permission::create(['name' => 'slip_gaji_user']);
        Permission::create(['name' => 'slip_gaji_admin']);
        Permission::create(['name' => 'rekap_presensi_user']);
        Permission::create(['name' => 'rekap_presensi_admin']);
        Permission::create(['name' => 'perhitungan_gaji']);
        Permission::create(['name' => 'create_user']);
        Permission::create(['name' => 'PT_SMK']);
        Permission::create(['name' => 'PT_AEI']);

        //create roles and assign existing permissions
        $karyawan = Role::create(['name' => 'karyawan']);
        $karyawan->givePermissionTo('dashboard_user');
        $karyawan->givePermissionTo('slip_gaji_user');
        $karyawan->givePermissionTo('rekap_presensi_user');
        // $karyawan->givePermissionTo('PT_SMK');
        // $karyawan->givePermissionTo('PT_AEI');


        $hrd = Role::create(['name' => 'hrd']);
        $hrd->givePermissionTo('dashboard_admin');
        $hrd->givePermissionTo('slip_gaji_admin');
        $hrd->givePermissionTo('rekap_presensi_admin');
        $hrd->givePermissionTo('perhitungan_gaji');
        $hrd->givePermissionTo('create_user');

        // gets all permissions via Gate::before rule

        // create demo users
        // $user = User::factory()->create([
        //     'name' => 'Edi',
        //     'email' => 'edi@salary.com',
        //     'password' => Hash::make('1')
        // ]);
        // $user->assignRole($karyawan);

        $user = User::factory()->create([
            'name' => 'HRD',
            'email' => 'hrd_smk@salary.com',
            'password' => Hash::make('2')
        ]);
        $user->assignRole($hrd)->givePermissionTo('PT_SMK');

        $user2 = User::factory()->create([
            'name' => 'HRD',
            'email' => 'hrd_aei@salary.com',
            'password' => Hash::make('2')
        ]);
        $user2->assignRole($hrd)->givePermissionTo('PT_AEI');
    }
}
