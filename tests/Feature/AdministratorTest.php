<?php

namespace Tests\Feature;

use App\Models\Administrators;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Log;
use Tests\TestCase;

class AdministratorTest extends TestCase
{
    public function testGetAdministrator()
    {
        $this->seed(DatabaseSeeder::class);

        $administrators = Administrators::query()->get();
        self::assertNotNull($administrators);

        $admins = [];
        foreach ($administrators as $admin) {
            $admins[] = $admin->admin_nik;
        }

        self::assertEquals(3, count($admins));
        self::assertTrue(in_array("55000154", $admins));
        self::assertTrue(in_array("31811016", $admins));
        self::assertTrue(in_array("31903007", $admins));
        self::assertFalse(in_array("55000153", $admins));

        Log::info($admins);
    }
}
