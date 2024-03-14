<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class SuperAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::create([
            'nik' => '55000154',
            'password' => bcrypt('@Fajarpaper123'),
            'fullname' => 'Doni Darmawan',
            'department' => 'EI2',
            'email_address' => 'doni.duaasattuu@gmail.com',
            'phone_number' => '08983456945',
            'created_at' => Carbon::now()->toDateTimeString(),
        ]);

        Role::insert([
            [
                'role' => 'admin',
                'created_at' => Carbon::now(),
            ],
            [
                'role' => 'superadmin',
                'created_at' => Carbon::now(),
            ],
        ]);

        $user->roles()->attach('admin');
        $user->roles()->attach('superadmin');
    }
}
