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
        $doni = new User();
        $doni->nik = "55000154";
        $doni->password = "@Fajarpaper123";
        $doni->fullname = "Doni Darmawan";
        $doni->department = "EI2";
        $doni->phone_number = "08983456945";
        $doni->save();

        $jamal = new User();
        $jamal->nik = "55000153";
        $jamal->password = "@Fajarpaper123";
        $jamal->fullname = "Jamal Mirdad";
        $jamal->department = "EI6";
        $jamal->phone_number = "085381243342";
        $jamal->save();

        $saiful = new User();
        $saiful->nik = "55000093";
        $saiful->password = "@Fajarpaper123";
        $saiful->fullname = "Saiful Bahri";
        $saiful->department = "EI2";
        $saiful->phone_number = "08982911546";
        $saiful->save();

        $mbeat = new User();
        $mbeat->nik = "55000092";
        $mbeat->password = "@Fajarpaper123";
        $mbeat->fullname = "R. Much Arief S";
        $mbeat->department = "EI2";
        $mbeat->phone_number = "087879107392";
        $mbeat->save();

        $ridwan = new User();
        $ridwan->nik = "32007012";
        $ridwan->password = "@Fajarpaper123";
        $ridwan->fullname = "Ridwan Abdurahman";
        $ridwan->department = "EI7";
        $ridwan->phone_number = "08991544689";
        $ridwan->save();

        $jiyantoro = new User();
        $jiyantoro->nik = "31100019";
        $jiyantoro->password = "@Fajarpaper123";
        $jiyantoro->fullname = "Jiyantoro";
        $jiyantoro->department = "EI7";
        $jiyantoro->phone_number = "08991544689";
        $jiyantoro->save();

        $prima = new User();
        $prima->nik = "31811016";
        $prima->password = "@Fajarpaper123";
        $prima->fullname = "Prima Hendra Kusuma";
        $prima->department = "EI5";
        $prima->phone_number = "085159963630";
        $prima->save();

        $yuan = new User();
        $yuan->nik = "31903007";
        $yuan->password = "@Fajarpaper123";
        $yuan->fullname = "Yuan Lucky Prasetyo Winarno";
        $yuan->department = "EI5";
        $yuan->phone_number = "081383294790";
        $yuan->save();

        $darminto = new User();
        $darminto->nik = "31100171";
        $darminto->password = "@Fajarpaper123";
        $darminto->fullname = "Darminto";
        $darminto->department = "EI2";
        $darminto->phone_number = "085811043635";
        $darminto->save();

        $edi = new User();
        $edi->nik = "55000135";
        $edi->password = "@Fajarpaper123";
        $edi->fullname = "Edi Supriadi";
        $edi->department = "EI2";
        $edi->phone_number = "082112424780";
        $edi->save();

        $suryanto = new User();
        $suryanto->nik = "31100156";
        $suryanto->password = "@Fajarpaper123";
        $suryanto->fullname = "Suryanto";
        $suryanto->department = "EI2";
        $suryanto->phone_number = "085711412097";
        $suryanto->save();
    }
}
