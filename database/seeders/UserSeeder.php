<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table("users")->delete();

        $user = new User();
        $user->nik = "55000154";
        $user->password = "1234";
        $user->fullname = "Doni Darmawan";
        $user->department = "EI2";
        $user->phone_number = "08983456945";
        $user->save();

        $user1 = new User();
        $user1->nik = "1234";
        $user1->password = "1234";
        $user1->fullname = "Guest";
        $user1->department = "EI2";
        $user1->phone_number = "12345678910";
        $user1->save();
    }
}
