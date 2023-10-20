<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = new User();
        $user->nik = "55000154";
        $user->password = "1234";
        $user->fullname = "Doni Darmawan";
        $user->department = "EI2";
        $user->phone_number = "08983456945";
        $user->save();
    }
}
