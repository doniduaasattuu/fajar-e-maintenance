<?php

namespace Tests\Feature;

use App\Models\Emo;
use App\Models\EmoDetail;
use App\Models\EmoRecord;
use App\Models\FunctionLocation;
use Carbon\Carbon;
use Database\Seeders\DatabaseSeeder;
use Database\Seeders\EmoDetailSeeder;
use Database\Seeders\EmoRecordSeeder;
use Database\Seeders\EmoSeeder;
use Database\Seeders\FunctionLocationSeeder;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Tests\TestCase;

class EmoTest extends TestCase
{
    public function testCreateEmo()
    {
        $this->seed(FunctionLocationSeeder::class);

        $emo = new Emo();
        $emo->id = "EMO000426";
        $emo->funcloc = "FP-01-SP3-RJS-T092-P092";
        $emo->material_number = "10010668";
        $emo->equipment_description = "AC MOTOR;380V,50Hz,75kW,4P,250M,B3";
        $emo->status = "Installed";
        $emo->sort_field = "SP3.P.70/M";
        $emo->unique_id = "1804";
        $emo->qr_code_link = "https://www.safesave.info/MIC.php?id=Fajar-MotorList1804";
        $emo->created_at = Carbon::now()->toDateTimeString();
        $emo->updated_at = Carbon::now()->toDateTimeString();
        $result = $emo->save();

        self::assertTrue($result);
        self::assertNotNull($emo);
        self::assertEquals("EMO000426", $emo->id);
    }

    public function testCreateEmoDuplicateId()
    {
        $this->testCreateEmo();

        try {
            $emo = new Emo();
            $emo->id = "EMO000426";
            $emo->funcloc = null;
            $emo->material_number = null;
            $emo->equipment_description = "AC MOTOR;380V,50Hz,55kW,4P,250M,B3";
            $emo->status = "Available";
            $emo->sort_field = "SP3.P.70/M";
            $emo->unique_id = "1234";
            $emo->qr_code_link = "https://www.safesave.info/MIC.php?id=Fajar-MotorList1234";
            $emo->created_at = Carbon::now()->toDateTimeString();
            $emo->updated_at = Carbon::now()->toDateTimeString();
            $result = $emo->save();
        } catch (QueryException $exception) {

            self::assertEquals("Duplicate entry 'EMO000426' for key 'PRIMARY'", $exception->errorInfo[2]);
        }
    }

    public function testCreateEmoDescriptionEmpty()
    {
        DB::table('emos')->delete();
        $this->seed(FunctionLocationSeeder::class);

        try {
            $emo = new Emo();
            $emo->id = "EMO000426";
            $emo->funcloc = null;
            $emo->material_number = null;
            $emo->equipment_description = null;
            $emo->status = "Available";
            $emo->sort_field = "SP3.P.70/M";
            $emo->unique_id = "1234";
            $emo->qr_code_link = "https://www.safesave.info/MIC.php?id=Fajar-MotorList1234";
            $emo->created_at = Carbon::now()->toDateTimeString();
            $emo->updated_at = Carbon::now()->toDateTimeString();
            $result = $emo->save();
        } catch (QueryException $exception) {
            self::assertEquals("Column 'equipment_description' cannot be null", $exception->errorInfo[2]);
        }
    }

    public function testCreateEmoDuplicateFuncloc()
    {
        $this->testCreateEmo();

        $emo = new Emo();
        $emo->id = "EMO000123";
        $emo->funcloc = "FP-01-SP3-RJS-T092-P092";
        $emo->material_number = "10010668";
        $emo->equipment_description = "AC MOTOR;380V,50Hz,55kW,4P,250M,B3";
        $emo->status = "Installed";
        $emo->sort_field = "SP3.P.70/M";
        $emo->unique_id = "1234";
        $emo->qr_code_link = "https://www.safesave.info/MIC.php?id=Fajar-MotorList1234";
        $emo->created_at = Carbon::now()->toDateTimeString();
        $emo->updated_at = Carbon::now()->toDateTimeString();
        $result = $emo->save();

        self::assertTrue($result);
        self::assertNotNull($emo);
        self::assertEquals("EMO000123", $emo->id);

        $emos = Emo::query()->where("funcloc", "FP-01-SP3-RJS-T092-P092")->get();
        self::assertCount(2, $emos);
    }

    public function testCreateEmoDuplicateUniqueId()
    {
        $this->testCreateEmo();

        try {
            $emo1 = new Emo();
            $emo1->id = "EMO000123";
            $emo1->funcloc = "FP-01-SP3-RJS-T092-P092";
            $emo1->material_number = "10010668";
            $emo1->equipment_description = "AC MOTOR;380V,50Hz,55kW,4P,250M,B3";
            $emo1->status = "Available";
            $emo1->sort_field = "SP3.P.70/M";
            $emo1->unique_id = "1804";
            $emo1->qr_code_link = "https://www.safesave.info/MIC.php?id=Fajar-MotorList1804";
            $emo1->created_at = Carbon::now()->toDateTimeString();
            $emo1->updated_at = Carbon::now()->toDateTimeString();
            $result = $emo1->save();
        } catch (QueryException $exception) {
            self::assertEquals("Duplicate entry '1804' for key 'emos_unique_id_unique'", $exception->errorInfo[2]);
        }

        $emos = Emo::query()->where("unique_id", "1804")->get();
        self::assertCount(1, $emos);
    }

    public function testCreateEmoDuplicateQrCodeLink()
    {
        $this->testCreateEmo();

        try {
            $emo1 = new Emo();
            $emo1->id = "EMO000321";
            $emo1->funcloc = "FP-01-SP3-RJS-T092-P092";
            $emo1->material_number = "10010668";
            $emo1->equipment_description = "AC MOTOR;380V,50Hz,55kW,4P,250M,B3";
            $emo1->status = "Available";
            $emo1->sort_field = "SP3.P.70/M";
            $emo1->unique_id = "1234";
            $emo1->qr_code_link = "https://www.safesave.info/MIC.php?id=Fajar-MotorList1804";
            $emo1->created_at = Carbon::now()->toDateTimeString();
            $emo1->updated_at = Carbon::now()->toDateTimeString();
            $result = $emo1->save();
        } catch (QueryException $exception) {
            self::assertEquals("Duplicate entry 'https://www.safesave.info/MIC.php?id=Fajar-MotorList1804' for key 'emos_qr_code_link_unique'", $exception->errorInfo[2]);
        }

        $emos = Emo::query()->where("qr_code_link", "https://www.safesave.info/MIC.php?id=Fajar-MotorList1804")->get();
        self::assertCount(1, $emos);
    }

    public function testEmoToEmoDetailRelations()
    {
        $this->seed([FunctionLocationSeeder::class, EmoSeeder::class, EmoDetailSeeder::class]);

        $emo = Emo::query()->with("emoDetails")->find("EMO000426");
        $emo_detail = $emo->emoDetails;

        self::assertNotNull($emo_detail);
        self::assertNotNull($emo_detail->power_rate, '75');
        self::assertNotNull($emo_detail->ip_rating, '55');
        self::assertNotNull($emo_detail->cooling_fan, 'Internal');
    }

    public function testEmoToFunclocRelations()
    {
        $this->seed([FunctionLocationSeeder::class, EmoSeeder::class, EmoDetailSeeder::class]);

        $emo = Emo::query()->with('funcloc')->find("EMO000426");
        self::assertNotNull($emo);
        $funcloc = $emo->funcLoc;

        self::assertNotNull($funcloc);
        self::assertEquals("FP-01-SP3-RJS-T092-P092", $funcloc->id);
    }

    public function testEmoToEmoRecordsRelationsFound()
    {
        $this->seed(DatabaseSeeder::class);

        $end_date = Carbon::now()->addDays(1);
        $start_date = Carbon::now()->addYears(-1)->addDays(-1);

        // $emo = Emo::query()->whereBetween("created_at", [$start_date, $end_date])->find("EMO000426");
        // $emo_records = $emo->emoRecords->toQuery()->whereBetween("created_at", [$start_date, $end_date])->get();
        $emo_records = EmoRecord::whereBetween("created_at", [$start_date, $end_date])->where("emo", "EMO000426")->get();

        // self::assertNotNull($emo);
        // self::assertNotNull($emo->emoRecords);
        // self::assertCount(36, $emo->emoRecords);
        self::assertCount(12, $emo_records);
        Log::info(json_encode($emo_records, JSON_PRETTY_PRINT));
    }

    public function testEmoToEmoRecordsRelationsNotFound()
    {
        $this->seed(DatabaseSeeder::class);

        $emo = Emo::query()->with(['emoRecords'])->find("EMO000000");
        self::assertNull($emo);
    }

    public function testEmoQueryWith()
    {
        $this->seed(DatabaseSeeder::class);

        $emo = Emo::query()->with("funcloc", "emoDetails")->find("EMO000426");
        self::assertNotNull($emo);

        self::assertEquals("FP-01-SP3-RJS-T092-P092", $emo->funcLoc->id);
        self::assertEquals("Horizontal", $emo->emoDetails->mounting);
    }
}
