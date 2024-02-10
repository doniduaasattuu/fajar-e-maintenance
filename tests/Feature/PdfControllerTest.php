<?php

namespace Tests\Feature;

use App\Models\Funcloc;
use App\Models\MotorRecord;
use App\Models\User;
use Database\Seeders\DailyRecordSeeder;
use Database\Seeders\FunclocSeeder;
use Database\Seeders\MotorSeeder;
use Database\Seeders\RoleSeeder;
use Database\Seeders\TrafoSeeder;
use Database\Seeders\UserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Log;
use Tests\TestCase;

class PdfControllerTest extends TestCase
{
    public function testPdf()
    {
        $this->seed([UserSeeder::class, RoleSeeder::class, FunclocSeeder::class, MotorSeeder::class, TrafoSeeder::class, DailyRecordSeeder::class]);

        $records = MotorRecord::query()->get();
        self::assertNotNull($records);
        $records = $records->map(function ($values, $keys) {
            $values = collect($values);

            return $values->map(function ($value, $key) {
                if ($key == 'nik') {
                    $name = User::query()->find($value)->printed_name;
                    return $name;
                } else {
                    return $value;
                }
            });
        });
        Log::info(json_encode($records, JSON_PRETTY_PRINT));
    }
}
