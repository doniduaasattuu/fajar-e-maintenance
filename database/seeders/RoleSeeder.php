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

        $assign = new Role();
        $assign->nik = $users->find('31811016')->nik;
        $assign->role = 'db_admin';
        $assign->save();

        $assign = new Role();
        $assign->nik = $users->find('55000154')->nik;
        $assign->role = 'db_admin';
        $assign->save();

        $assign = new Role();
        $assign->nik = $users->find('55000154')->nik;
        $assign->role = 'admin';
        $assign->save();
    }
}
