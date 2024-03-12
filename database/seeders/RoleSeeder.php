<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Carbon\Carbon;
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
        DB::table('roles')->delete();

        $roles = [
            [
                'role' => 'admin',
                'created_at' => Carbon::now(),
            ],
            [
                'role' => 'superadmin',
                'created_at' => Carbon::now(),
            ],
        ];

        Role::insert($roles);
    }
}
