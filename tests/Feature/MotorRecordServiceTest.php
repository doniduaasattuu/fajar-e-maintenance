<?php

namespace Tests\Feature;

use App\Services\MotorRecordService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Log;
use Tests\TestCase;

class MotorRecordServiceTest extends TestCase
{
    public function testMotorRecordColumns()
    {
        $motorRecordService = $this->app->make(MotorRecordService::class);
        self::assertNotNull($motorRecordService);
        $columns = $motorRecordService->getColumns('motor_records');
        self::assertNotNull($columns);
        self::assertCount(30, $columns);
        Log::info(json_encode($columns, JSON_PRETTY_PRINT));
    }
}
