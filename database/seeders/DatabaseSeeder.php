<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        DB::table('motor_details')->delete();
        DB::table('motors')->delete();
        DB::table('funclocs')->delete();
        DB::table('roles')->delete();
        DB::table('users')->delete();

        $this->call([
            UserSeeder::class,
            RoleSeeder::class,
            FunclocSeeder::class,
            MotorSeeder::class,
            MotorDetailsSeeder::class,
        ]);
    }
}
