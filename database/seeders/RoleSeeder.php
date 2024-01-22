<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::query()->get();

        $prima = new Role();
        $prima->nik = $users->find('31811016')->nik;
        $prima->role = 'db_admin';
        $prima->save();

        $yuan = new Role();
        $yuan->nik = $users->find('31903007')->nik;
        $yuan->role = 'db_admin';
        $yuan->save();

        $doni = new Role();
        $doni->nik = $users->find('55000154')->nik;
        $doni->role = 'db_admin';
        $doni->save();

        $doni = new Role();
        $doni->nik = $users->find('55000154')->nik;
        $doni->role = 'admin';
        $doni->save();
    }
}
