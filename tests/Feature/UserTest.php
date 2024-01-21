<?php

namespace Tests\Feature;

use App\Models\User;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Log;
use Tests\TestCase;

class UserTest extends TestCase
{
    public function testUserRelationToRole()
    {
        $this->seed(DatabaseSeeder::class);

        $user = User::query()->with(['roles'])->find('55000154');
        self::assertNotNull($user->roles);
        Log::info(json_encode($user->roles, JSON_PRETTY_PRINT));

        $roles = $user->roles;
        $roles = $roles->map(function ($value, $key) {
            return $value->role;
        });
        Log::info(json_encode($roles, JSON_PRETTY_PRINT));

        self::assertTrue($roles->contains('admin'));
        self::assertFalse($roles->contains('employee'));
        self::assertTrue($roles->contains('db_admin'));
    }
}
