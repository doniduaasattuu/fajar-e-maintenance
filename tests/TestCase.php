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
        DB::table('transformer_details')->delete();
        DB::table('transformers')->delete();
        DB::table('emo_records')->truncate();
        DB::table('emo_details')->delete();
        DB::table('emos')->delete();
        DB::table('function_locations')->delete();
        DB::table('administrators')->delete();
        DB::table('users')->delete();
    }
}
