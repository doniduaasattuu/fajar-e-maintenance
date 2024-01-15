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
        $user1 = new User();
        $user1->nik = '55000154';
        $user1->password = '@Fajarpaper123';
        $user1->fullname = 'Doni Darmawan';
        $user1->department = 'EI2';
        $user1->phone_number = '08983456945';
        $user1->save();

        $user2 = new User();
        $user2->nik = '55000153';
        $user2->password = '@Fajarpaper123';
        $user2->fullname = 'Jamal Mirdad';
        $user2->department = 'EI6';
        $user2->phone_number = '08983456945';
        $user2->save();
    }
}
