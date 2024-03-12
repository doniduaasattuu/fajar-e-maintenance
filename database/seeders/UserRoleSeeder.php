<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserRoleSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('user_role')->delete();
        DB::table('users')->delete();
        DB::table('roles')->delete();

        $this->call([
            UserSeeder::class,
            RoleSeeder::class,
        ]);

        $user = User::query()->find('55000154');
        $user->roles()->attach('admin');
        $user->roles()->attach('superadmin');

        $user = User::query()->find('55000153');
        $user->roles()->attach('admin');
    }
}
