<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Facades\DB;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected function setUp(): void
    {
        parent::setUp();
        DB::delete('delete from roles');
        DB::delete('delete from users');
        DB::delete('delete from motor_details');
        DB::delete('delete from motors');
        DB::delete('delete from funclocs');
    }
}
