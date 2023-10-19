<?php

namespace Tests\Feature;

use App\Models\Emo;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Log;
use Tests\TestCase;

class DataControllerTest extends TestCase
{
    public function testScanner()
    {
        $this->seed(DatabaseSeeder::class);

        // $qr_code_link = "https:/" . "/www.safesave.info" . "/" . "MIC.php?id=" . "MotorList1804";

        $motorList = "Fajar-MotorList1804";
        $uri = "https://www.safesave.info/MIC.php?id=" . $motorList;

        echo $uri;

        $emo = Emo::query()->with("funcLoc", "emoDetail")->where("qr_code_link", "=", $uri)->first();
        // self::assertNotNull($emo);
        Log::info(json_encode($emo, JSON_PRETTY_PRINT));
    }
}
