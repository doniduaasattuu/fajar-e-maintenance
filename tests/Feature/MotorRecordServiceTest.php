<?php

namespace Tests\Feature;

use App\Services\MotorRecordService;
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
    }
}
