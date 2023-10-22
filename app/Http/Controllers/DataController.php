<?php

namespace App\Http\Controllers;

use App\Models\DataRecord;
use App\Models\Emo;
use Carbon\Carbon;
use Ghunti\HighchartsPHP\Highchart;
use Ghunti\HighchartsPHP\HighchartJsExpr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

use function PHPUnit\Framework\returnCallback;

class DataController extends Controller
{
    public function getForm(Request $request, string $motorList)
    {

        $uri = "https://www.safesave.info/MIC.php?id=" . $motorList;
        $emo = Emo::query()->with("funcLoc", "emoDetails")->where("qr_code_link", "=", $uri)->first();

        if (!is_null($emo)) {

            return response()->view("maintenance.checking-form", [
                "title" => "Checking Form",
                "emo" => $emo,
                "funcLoc" => $emo->funcLoc->toArray(),
                "emoDetail" => $emo->emoDetails->toArray(),
            ]);
        } else {
            return response()->view("utility.page-not-found", [
                "title" => "Oops!"
            ]);
        }
    }

    public function search(Request $request)
    {
        $search_data = $request->input("search_data");

        if (!empty($search_data) && strlen($search_data) == 19 && $search_data[0] == "F" && $search_data[6] == "M") {
            // Search by list qr_code_link = Fajar-MotorList1804
            $url = action([DataController::class, "getForm"], [
                "motorList" => $search_data
            ]);

            return redirect($url);
        } else if (!empty($search_data) && strlen($search_data) == 9 && $search_data[3] == "0") {
            // Search by emo or mgm = EMO000426
            $emo = Emo::query()->with("funcLoc", "emoDetails")->find($search_data);

            if (!is_null($emo)) {
                $motorList = substr($emo->qr_code_link, -19);

                // Fajar-MotorList1804
                $url = action([DataController::class, "getForm"], [
                    "motorList" => $motorList
                ]);

                return redirect($url);
            } else {
                return response()->view("utility.page-not-found", [
                    "title" => "Oops!"
                ]);
            }
        } else if (!empty($search_data) && strlen($search_data) == 4) {
            // Search by unique_id = 1804
            $unique_id = Emo::query()->where("unique_id", "=", $search_data)->first();

            if (!is_null($unique_id)) {
                $motorList = substr($unique_id->qr_code_link, -19);

                // Fajar-MotorList1804
                $url = action([DataController::class, "getForm"], [
                    "motorList" => $motorList
                ]);

                return redirect($url);
            } else {
                return response()->view("utility.page-not-found", [
                    "title" => "Oops!"
                ]);
            }
        } else {
            return response()->view("utility.page-not-found", [
                "title" => "Oops!"
            ]);
        }
    }

    public function saveData(Request $request)
    {
        $motor_status = $request->input("motor_status");
        $clean_status = $request->input("clean_status");
        $nipple_grease_input = $request->input("nipple_grease_input");
        $number_of_greasing_input = $request->input("number_of_greasing_input");
        $temperature_a = $request->input("temperature_a");
        $temperature_b = $request->input("temperature_b");
        $temperature_c = $request->input("temperature_c");
        $temperature_d = $request->input("temperature_d");
        $vibration_value_de = $request->input("vibration_value_de");
        $vibration_de = $request->input("vibration_de");
        $vibration_value_nde = $request->input("vibration_value_nde");
        $vibration_nde = $request->input("vibration_nde");
    }

    public function trends(Request $request, string $emo)
    {
        $endDate = Carbon::now();
        $startDate = Carbon::now()->addDays(-30);

        $data_records = DataRecord::query()->whereBetween("created_at", [$startDate, $endDate])->where("emo", "=", $emo)->get();

        $date_category = [];
        $temperature_a = [];
        $temperature_b = [];
        $temperature_c = [];
        $temperature_d = [];
        $vibration_value_de = [];
        $vibration_value_nde = [];
        $number_of_greasing = [];
        foreach ($data_records as $record) {
            $month = substr($record->created_at, 5, 2);
            $date = substr($record->created_at, 8, 2);
            array_push($date_category, $date . "/" . $month);

            array_push($temperature_a, $record->temperature_a);
            array_push($temperature_b, $record->temperature_b);
            array_push($temperature_c, $record->temperature_c);
            array_push($temperature_d, $record->temperature_d);

            array_push($vibration_value_de, (float) $record->vibration_value_de);
            array_push($vibration_value_nde, (float) $record->vibration_value_nde);
            array_push($number_of_greasing, $record->number_of_greasing);
        }

        return view("maintenance.trends", [
            "title" => "Data",
            "date_category" => $date_category,
            "temperature_a" => $temperature_a,
            "temperature_b" => $temperature_b,
            "temperature_c" => $temperature_c,
            "temperature_d" => $temperature_d,
            "vibration_value_de" => $vibration_value_de,
            "vibration_value_nde" => $vibration_value_nde,
            "number_of_greasing" => $number_of_greasing,
            "emo" => $emo,
        ]);
    }
}
