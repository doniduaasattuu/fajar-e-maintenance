<?php

namespace Tests;

use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Facades\DB;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected function setUp(): void
    {
        parent::setUp();
        DB::delete('delete from pub_shares');
        DB::delete('delete from email_recipients');
        DB::delete('delete from documents');
        DB::delete('delete from findings');
        DB::delete('delete from trafo_records');
        DB::delete('delete from trafo_details');
        DB::delete('delete from trafos');
        DB::delete('delete from motor_records');
        DB::delete('delete from motor_details');
        DB::delete('delete from motors');
        DB::delete('delete from funclocs');
        DB::delete('delete from user_role');
        DB::delete('delete from roles');
        DB::delete('delete from users');
    }
}
