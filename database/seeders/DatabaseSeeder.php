<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Finding;
use App\Models\MotorRecord;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        DB::table('issues')->delete();
        DB::table('pub_shares')->delete();
        DB::table('email_recipients')->delete();
        DB::table('documents')->delete();
        DB::table('findings')->delete();
        DB::table('trafo_records')->delete();
        DB::table('trafo_details')->delete();
        DB::table('trafos')->delete();
        DB::table('motor_records')->delete();
        DB::table('motor_details')->delete();
        DB::table('motors')->delete();
        DB::table('funclocs')->delete();
        DB::table('user_role')->delete();
        DB::table('roles')->delete();
        DB::table('users')->delete();

        $this->call([
            UserRoleSeeder::class,
            FunclocSeeder::class,
            MotorSeeder::class,
            MotorDetailsSeeder::class,
            MotorRecordSeeder::class,
            TrafoSeeder::class,
            TrafoDetailsSeeder::class,
            TrafoRecordSeeder::class,
            FindingSeeder::class,
            DocumentSeeder::class,
            DailyRecordSeeder::class,
            EmailRecipientSeeder::class,
            IssueSeeder::class,
        ]);
    }
}
