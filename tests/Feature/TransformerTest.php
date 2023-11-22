<?php

namespace Tests\Feature;

use App\Models\Transformers;
use Carbon\Carbon;
use Database\Seeders\DatabaseSeeder;
use Database\Seeders\FunctionLocationSeeder;
use Database\Seeders\TransformerDetailSeeder;
use Database\Seeders\TransformersSeeder;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Tests\TestCase;

class TransformerTest extends TestCase
{
    public function testCreateTrafo()
    {
        $this->seed(FunctionLocationSeeder::class);

        $trafo = new Transformers();
        $trafo->id = "ETF000085";
        $trafo->status = "Installed";
        $trafo->funcloc = "FP-01-IN1";
        $trafo->sort_field = "TR PLN";
        $trafo->material_number = null;
        $trafo->equipment_description = "TR PLN";
        $trafo->unique_id = "1";
        $trafo->qr_code_link = "id=Fajar-TrafoList1";
        $trafo->created_at = Carbon::now()->toDateTimeString();
        $trafo->updated_at = Carbon::now()->toDateTimeString();
        $result = $trafo->save();

        self::assertTrue($result);
        self::assertNotNull($trafo);
        self::assertEquals("ETF000085", $trafo->id);
    }

    public function testCreateTrafoDuplicateId()
    {
        $this->testCreateTrafo();

        try {
            $trafo = new Transformers();
            $trafo->id = "ETF000085";
            $trafo->status = "Installed";
            $trafo->funcloc = "FP-01-IN1";
            $trafo->sort_field = "TR PLN";
            $trafo->material_number = null;
            $trafo->equipment_description = "TR PLN";
            $trafo->unique_id = "1";
            $trafo->qr_code_link = "id=Fajar-TrafoList1";
            $trafo->created_at = Carbon::now()->toDateTimeString();
            $trafo->updated_at = Carbon::now()->toDateTimeString();
            $result = $trafo->save();
        } catch (QueryException $exception) {

            self::assertEquals("Duplicate entry 'ETF000085' for key 'PRIMARY'", $exception->errorInfo[2]);
        }
    }

    public function testCreateTrafoDescriptionEmpty()
    {
        DB::table('transformers')->delete();
        $this->seed(FunctionLocationSeeder::class);

        try {
            $trafo = new Transformers();
            $trafo->id = "ETF000085";
            $trafo->status = "Installed";
            $trafo->funcloc = "FP-01-IN1";
            $trafo->sort_field = "TR PLN";
            $trafo->material_number = null;
            $trafo->equipment_description = null;
            $trafo->unique_id = "1";
            $trafo->qr_code_link = "id=Fajar-TrafoList1";
            $trafo->created_at = Carbon::now()->toDateTimeString();
            $trafo->updated_at = Carbon::now()->toDateTimeString();
            $result = $trafo->save();
        } catch (QueryException $exception) {
            self::assertEquals("Column 'equipment_description' cannot be null", $exception->errorInfo[2]);
        }
    }

    public function testCreateTrafoDuplicateFuncloc()
    {
        $this->testCreateTrafo();

        $trafo = new Transformers();
        $trafo->id = "ETF000086";
        $trafo->status = "Installed";
        $trafo->funcloc = "FP-01-IN1";
        $trafo->sort_field = "TR FAJAR";
        $trafo->material_number = null;
        $trafo->equipment_description = "TR FAJAR";
        $trafo->unique_id = "999";
        $trafo->qr_code_link = "id=Fajar-TrafoList999";
        $trafo->created_at = Carbon::now()->toDateTimeString();
        $trafo->updated_at = Carbon::now()->toDateTimeString();
        $result = $trafo->save();

        self::assertTrue($result);
        self::assertNotNull($trafo);
        self::assertEquals("ETF000086", $trafo->id);

        $trafos = Transformers::query()->where("funcloc", "FP-01-IN1")->get();
        self::assertCount(2, $trafos);
    }

    public function testCreateTrafoDuplicateUniqueId()
    {
        $this->testCreateTrafo();

        try {
            $trafo = new Transformers();
            $trafo->id = "ETF000089";
            $trafo->status = "Installed";
            $trafo->funcloc = "FP-01-IN1";
            $trafo->sort_field = "TR FAJAR";
            $trafo->material_number = null;
            $trafo->equipment_description = "TR FAJAR";
            $trafo->unique_id = "1";
            $trafo->qr_code_link = "id=Fajar-TrafoList1";
            $trafo->created_at = Carbon::now()->toDateTimeString();
            $trafo->updated_at = Carbon::now()->toDateTimeString();
            $result = $trafo->save();
        } catch (QueryException $exception) {
            self::assertEquals("Duplicate entry '1' for key 'transformers_unique_id_unique'", $exception->errorInfo[2]);
        }

        $trafos = Transformers::query()->where("unique_id", "1")->get();
        self::assertCount(1, $trafos);
    }

    public function testCreateTrafoDuplicateQrCodeLink()
    {
        $this->testCreateTrafo();

        try {
            $trafo = new Transformers();
            $trafo->id = "ETF000089";
            $trafo->status = "Installed";
            $trafo->funcloc = "FP-01-IN1";
            $trafo->sort_field = "TR FAJAR";
            $trafo->material_number = null;
            $trafo->equipment_description = "TR FAJAR";
            $trafo->unique_id = "1234";
            $trafo->qr_code_link = "id=Fajar-TrafoList1";
            $trafo->created_at = Carbon::now()->toDateTimeString();
            $trafo->updated_at = Carbon::now()->toDateTimeString();
            $result = $trafo->save();
        } catch (QueryException $exception) {
            self::assertEquals("Duplicate entry 'id=Fajar-TrafoList1' for key 'transformers_qr_code_link_unique'", $exception->errorInfo[2]);
        }

        $trafos = Transformers::query()->where("qr_code_link", "id=Fajar-TrafoList1")->get();
        self::assertCount(1, $trafos);
    }

    public function testTransformersToTransformerDetailRelations()
    {
        $this->seed([FunctionLocationSeeder::class, TransformersSeeder::class, TransformerDetailSeeder::class]);

        $trafo = Transformers::query()->with("transformerDetails")->find("ETF000085");
        $trafo_detail = $trafo->transformerDetails;

        Log::info(json_encode($trafo));

        self::assertNotNull($trafo_detail);
        self::assertNotNull($trafo_detail->type, "Step Down");
        self::assertNotNull($trafo_detail->type_of_cooling, "ONAN/ONAF");
        self::assertNotNull($trafo_detail->primary_voltage, "150000");
    }

    public function testTransfomersToFunclocRelations()
    {
        $this->seed([FunctionLocationSeeder::class, TransformersSeeder::class, TransformerDetailSeeder::class]);

        $trafo = Transformers::query()->with('funcloc')->find("ETF000085");
        self::assertNotNull($trafo);
        $funcloc = $trafo->funcLoc;

        self::assertNotNull($funcloc);
        self::assertEquals("FP-01-IN1", $funcloc->id);
    }

    public function testTransformersQueryWith()
    {
        $this->seed(DatabaseSeeder::class);

        $trafo = Transformers::query()->with("funcloc", "transformerDetails")->find("ETF000085");
        self::assertNotNull($trafo);

        self::assertEquals("FP-01-IN1", $trafo->funcLoc->id);
        self::assertEquals("Ynyn 0 + d", $trafo->transformerDetails->vector_group);
    }
}
