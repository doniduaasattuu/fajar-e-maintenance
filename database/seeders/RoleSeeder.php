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
        DB::table('roles')->truncate();

        $roles = [
            [
                'id' => 1,
                'role' => 'user',
                'created_at' => Carbon::now(),
            ],
            [
                'id' => 2,
                'role' => 'admin',
                'created_at' => Carbon::now(),
            ],
            [
                'id' => 3,
                'role' => 'superadmin',
                'created_at' => Carbon::now(),
            ],
        ];

        Role::insert($roles);
    }
}
