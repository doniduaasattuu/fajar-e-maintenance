<?php

namespace Database\Seeders;

use App\Models\Administrators;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AdministratorsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $doni = new Administrators();
        $doni->admin_nik = "55000154";
        $doni->save();

        $prima = new Administrators();
        $prima->admin_nik = "31811016";
        $prima->save();

        $yuan = new Administrators();
        $yuan->admin_nik = "31903007";
        $yuan->save();
    }
}
