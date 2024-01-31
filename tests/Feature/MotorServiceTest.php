<?php

namespace Tests\Feature;

use App\Models\Motor;
use App\Services\MotorService;
use Database\Seeders\FunclocSeeder;
use Database\Seeders\MotorSeeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Tests\TestCase;

class MotorServiceTest extends TestCase
{
    public function testMotorService()
    {
        $motorService = $this->app->make(MotorService::class);
        self::assertNotNull($motorService);
    }
    public function testMotorServiceGetAll()
    {
        $this->seed([FunclocSeeder::class, MotorSeeder::class]);

        $motorService = $this->app->make(MotorService::class);
        $motors = $motorService->getAll();
        self::assertNotNull($motors);
        self::assertNotEmpty($motors);
    }

    public function testMotorServiceGetTableColumns()
    {
        $motorService = $this->app->make(MotorService::class);
        $columns = $motorService->getTableColumns();
        self::assertNotNull($columns);
        self::assertCount(10, $columns);
    }

    public function testMotorServiceGetRegisteredMotors()
    {
        $this->seed([FunclocSeeder::class, MotorSeeder::class]);

        $motorService = $this->app->make(MotorService::class);
        $motors = $motorService->registeredMotors();
        self::assertNotEmpty($motors);
        self::assertCount(22, $motors);
    }

    public function testUpdateMotorSuccess()
    {
        $this->seed([FunclocSeeder::class, MotorSeeder::class]);

        $motor = Motor::query()->find('EMO000105');
        self::assertNotNull($motor);
        self::assertEquals('AC MOTOR;380V,50Hz,7.5kW,4P,132M,B3', $motor->description);

        $validated = [
            'id' => $motor->id,
            'description' => 'AC MOTOR;380V,50Hz,75kW,4P,132M,B3',
        ];

        $motorService = $this->app->make(motorService::class);
        self::assertTrue($motorService->updateMotor($validated));

        $motor = motor::query()->find('EMO000105');
        self::assertNotEquals('AC MOTOR;380V,50Hz,7.5kW,4P,132M,B3', $motor->description);
        self::assertEquals('AC MOTOR;380V,50Hz,75kW,4P,132M,B3', $motor->description);
    }

    public function testMotorRegisteredUniqueIds()
    {
        $this->seed([FunclocSeeder::class, MotorSeeder::class]);

        $motorService = $this->app->make(MotorService::class);
        $uniqueIds = $motorService->registeredUniqueIds();
        self::assertNotNull($uniqueIds);
        self::assertNotEmpty($uniqueIds);
        self::assertCount(22, $uniqueIds);
        self::assertTrue(in_array('2100', $uniqueIds));
        self::assertTrue(in_array('9999', $uniqueIds));
        self::assertFalse(in_array('1010', $uniqueIds));
    }

    public function testMotorRegisteredQrCodeLinks()
    {
        $this->seed([FunclocSeeder::class, MotorSeeder::class]);

        $motorService = $this->app->make(MotorService::class);
        $qrCodeLinks = $motorService->registeredQrCodeLinks();
        self::assertNotNull($qrCodeLinks);
        self::assertNotEmpty($qrCodeLinks);
        self::assertCount(22, $qrCodeLinks);
        self::assertTrue(in_array('https://www.safesave.info/MIC.php?id=Fajar-MotorList4592', $qrCodeLinks));
        self::assertTrue(in_array('https://www.safesave.info/MIC.php?id=Fajar-MotorList155', $qrCodeLinks));
        self::assertFalse(in_array('https://www.safesave.info/MIC.php?id=Fajar-MotorList111', $qrCodeLinks));
    }

    public function testMotorCodes()
    {
        $this->seed([FunclocSeeder::class, MotorSeeder::class]);

        $allCodes = DB::table('motors')->select(DB::raw('DISTINCT LEFT (id, 3) as codes'))->get();
        $motorCodes = array();
        foreach ($allCodes as $value) {
            array_push($motorCodes, $value->codes);
        }
        self::assertNotNull($motorCodes);
        self::assertEquals(['EMO', 'MGM'], $motorCodes);
    }

    public function testUtilityTrait()
    {
        $this->seed([FunclocSeeder::class, MotorSeeder::class]);

        $motorService = $this->app->make(MotorService::class);
        $columns = $motorService->getColumns('motors');
        self::assertNotNull($columns);
        self::assertCount(10, $columns);
    }


    public function testFilterValidatedValueRaw()
    {
        $this->seed([FunclocSeeder::class, MotorSeeder::class]);

        $motorService = $this->app->make(MotorService::class);

        $motorColumns = $motorService->getColumns('motors');
        self::assertNotNull($motorColumns);
        self::assertCount(10, $motorColumns);

        $motorDetailColumns = $motorService->getColumns('motor_details');
        self::assertNotNull($motorDetailColumns);
        self::assertCount(36, $motorDetailColumns);

        $mergedColumns = array_merge($motorColumns, $motorDetailColumns);
        self::assertCount(46, $mergedColumns);
        Log::info(json_encode($mergedColumns, JSON_PRETTY_PRINT));

        $filteredMotorColumns = array_values(array_diff($mergedColumns, $motorDetailColumns));
        self::assertCount(7, $filteredMotorColumns);
        self::assertEquals($filteredMotorColumns, [
            "status",
            "funcloc",
            "sort_field",
            "description",
            "material_number",
            "unique_id",
            "qr_code_link"
        ]);
    }

    public function testMotorServiceFilterValidatedValue()
    {
        $this->seed([FunclocSeeder::class, MotorSeeder::class]);

        $motorService = $this->app->make(MotorService::class);

        $motorColumns = $motorService->getColumns('motors');
        self::assertNotNull($motorColumns);


        $motorDetailColumns = $motorService->getColumns('motor_details', ['id']);
        self::assertNotNull($motorDetailColumns);

        $mergedColumns = array_merge($motorColumns, $motorDetailColumns);
        self::assertNotNull($mergedColumns);

        $filteredMotorColumns = $motorService->filterValidatedData($mergedColumns, $motorDetailColumns);
        Log::info(json_encode($filteredMotorColumns, JSON_PRETTY_PRINT));
    }

    public function testMergeRules()
    {
        $rules = [
            'id' => ['satu', 'dua', 'tiga'],
            'status' => ['satu', 'dua', 'tiga'],
            'funcloc' => ['satu', 'dua', 'tiga'],
            'sort_field' => ['satu', 'dua', 'tiga'],
        ];

        $rules1 = [
            'bearing_de' => ['satu', 'dua', 'tiga'],
            'bearing_nde' => ['satu', 'dua', 'tiga'],
            'frame_type' => ['satu', 'dua', 'tiga'],
            'shaft_diameter' => ['satu', 'dua', 'tiga'],
        ];

        $rules = array_merge($rules, $rules1);
        self::assertEquals($rules, [
            'id' => ['satu', 'dua', 'tiga'],
            'status' => ['satu', 'dua', 'tiga'],
            'funcloc' => ['satu', 'dua', 'tiga'],
            'sort_field' => ['satu', 'dua', 'tiga'],
            'bearing_de' => ['satu', 'dua', 'tiga'],
            'bearing_nde' => ['satu', 'dua', 'tiga'],
            'frame_type' => ['satu', 'dua', 'tiga'],
            'shaft_diameter' => ['satu', 'dua', 'tiga'],
        ]);
    }
}
