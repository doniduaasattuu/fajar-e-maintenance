<?php

namespace App\Http\Controllers;

use App\Models\DataRecord;
use App\Models\Emo;
use App\Models\EmoDetail;
use Carbon\Carbon;
use Ghunti\HighchartsPHP\Highchart;
use Ghunti\HighchartsPHP\HighchartJsExpr;
use Illuminate\Database\Events\QueryExecuted;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Redis;

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
                "motorList" => $motorList,
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

        if (!empty($search_data) && $search_data[0] == "F" && $search_data[6] == "M") {
            // Search by list qr_code_link = Fajar-MotorList1804
            $url = action([DataController::class, "getForm"], [
                "motorList" => $search_data
            ]);

            return redirect($url);
        } else if (!empty($search_data) && strlen($search_data) == 9 && $search_data[3] == "0") {
            // Search by emo or mgm = EMO000426
            $emo = Emo::query()->with("funcLoc", "emoDetails")->find($search_data);

            if (!is_null($emo)) {

                $qr_code_link = $emo->qr_code_link;
                $motorList = (explode("=", $qr_code_link))[1];

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
        } else if (!empty($search_data) && (strlen($search_data) >= 2) && (strlen($search_data) <= 4)) {
            // Search by unique_id = 1804
            $unique_id = Emo::query()->where("unique_id", "=", $search_data)->first();

            if (!is_null($unique_id)) {

                $qr_code_link = $unique_id->qr_code_link;
                $motorList = (explode("=", $qr_code_link))[1];

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

        $funcloc = $request->input("funcloc");
        $emo = $request->input("emo");
        $motor_status = $request->input("motor_status");
        $clean_status = $request->input("clean_status");
        $nipple_grease_input = $request->input("nipple_grease_input");
        $number_of_greasing_input = ($request->input("number_of_greasing_input") != null) ? $request->input("number_of_greasing_input") : 0;
        $temperature_a = $request->input("temperature_a");
        $temperature_b = $request->input("temperature_b");
        $temperature_c = $request->input("temperature_c");
        $temperature_d = $request->input("temperature_d");
        $vibration_value_de = $request->input("vibration_value_de");
        $vibration_de = $request->input("vibration_de");
        $vibration_value_nde = $request->input("vibration_value_nde");
        $vibration_nde = $request->input("vibration_nde");
        $comment = $request->input("comment");
        $checked_by = session("user");

        if (
            empty($motor_status) ||
            empty($clean_status) ||
            empty($nipple_grease_input) ||
            empty($temperature_a) ||
            empty($temperature_b) ||
            empty($temperature_c) ||
            empty($temperature_d) ||
            empty($vibration_value_de) ||
            empty($vibration_de) ||
            empty($vibration_value_nde) ||
            empty($vibration_nde)
        ) {
            return response()->json([
                "error" => "All field is required! ⚠️"
            ]);
        } else {

            try {
                $data_record = new DataRecord();

                $data_record->funcloc = $funcloc;
                $data_record->emo = $emo;
                $data_record->motor_status = $motor_status;
                $data_record->clean_status = $clean_status;
                $data_record->nipple_grease = $nipple_grease_input;
                $data_record->number_of_greasing = $number_of_greasing_input;
                $data_record->temperature_a = $temperature_a;
                $data_record->temperature_b = $temperature_b;
                $data_record->temperature_c = $temperature_c;
                $data_record->temperature_d = $temperature_d;
                $data_record->vibration_value_de = $vibration_value_de;
                $data_record->vibration_de = $vibration_de;
                $data_record->vibration_value_nde = $vibration_value_nde;
                $data_record->vibration_nde = $vibration_nde;
                $data_record->comment = $comment;
                $data_record->created_at = Carbon::now()->toDateTimeString();
                $data_record->checked_by = $checked_by;
                $result = $data_record->save();
            } catch (QueryException $error) {
                return response()->json([
                    "error" => $error
                ]);
            }

            if ($result) {
                return response()->json([
                    "message" => "Saved successfully! ✅"
                ]);
            } else { {
                    return response()->json([
                        "error" => "Error occurred! ⚠️"
                    ]);
                }
            }
        }
    }

    public function trends(Request $request, string $emo)
    {
        if (strlen($emo) == 9) {
            $endDate = !is_null($request->input("end_date")) ? $request->input("end_date") : Carbon::now();
            $startDate = !is_null($request->input("start_date")) ? $request->input("start_date") : Carbon::now()->addYears(-1);

            $data_records = DataRecord::query()->whereBetween("created_at", [$startDate, $endDate])->where("emo", "=", $emo)->get();
            $emo_details = EmoDetail::query()->where("emo_detail", "=", $emo)->first();

            $comments = DataRecord::query()
                ->select(["comment", "funcloc", "checked_by", "created_at"])->where("comment", "!=", null)
                ->where("emo", "=", $emo)
                ->orderBy("created_at", "DESC")
                ->get();

            if (!is_null($emo_details)) {

                $nipple_grease = $emo_details->nipple_grease;
                $date_category = [];
                $temperature_a = [];
                $temperature_b = [];
                $temperature_c = [];
                $temperature_d = [];
                $vibration_value_de = [];
                $vibration_value_nde = [];
                $number_of_greasing = [];

                foreach ($data_records as $record) {
                    $year = substr($record->created_at, 2, 2);
                    $month = substr($record->created_at, 5, 2);
                    $date = substr($record->created_at, 8, 2);
                    array_push($date_category, $date . "/" . $month . "/" . $year);

                    array_push($temperature_a, $record->temperature_a);
                    array_push($temperature_b, $record->temperature_b);
                    array_push($temperature_c, $record->temperature_c);
                    array_push($temperature_d, $record->temperature_d);

                    array_push($vibration_value_de, (float) $record->vibration_value_de);
                    array_push($vibration_value_nde, (float) $record->vibration_value_nde);
                    array_push($number_of_greasing, $record->number_of_greasing);
                }

                return response()->view("maintenance.trends", [
                    "title" => "Trends",
                    "date_category" => $date_category,
                    "temperature_a" => $temperature_a,
                    "temperature_b" => $temperature_b,
                    "temperature_c" => $temperature_c,
                    "temperature_d" => $temperature_d,
                    "vibration_value_de" => $vibration_value_de,
                    "vibration_value_nde" => $vibration_value_nde,
                    "number_of_greasing" => $number_of_greasing,
                    "emo" => $emo,
                    "nipple_grease" => $nipple_grease,
                    "comments" => $comments->toArray(),
                ]);
            } else {

                return Redirect::back();
            }
        } else {

            return Redirect::back();
        }
    }

    public function trendsPicker()
    {
        return response()->view("maintenance.trends-picker", [
            "title" => "Trends picker",
            "header" => "Equipment trend",
        ]);
    }

    public function emoDatalist()
    {
        $emo_list = DataRecord::query()->select("emo")->distinct()->get();
        return response()->json($emo_list);
    }

    // SUMMARY
    public function summary()
    {
        function returnData(string $temp_a, string $paper_machine)
        {
            $data = DataRecord::query()
                ->select(["funcloc", "emo", $temp_a, "created_at"])
                ->orderByDesc($temp_a)
                ->where("funcloc", "LIKE", "%PM$paper_machine%")
                ->orWhere("funcloc", "LIKE", "%SP$paper_machine%")
                ->orWhere("funcloc", "LIKE", "%FN$paper_machine%")
                ->orWhere("funcloc", "LIKE", "%CH$paper_machine%")
                ->whereBetween("created_at", [Carbon::now()->addMonths(-12), Carbon::now()])
                ->limit(5)
                ->get();

            return $data;
        }

        return response()->view("maintenance.summary", [
            "title" => "Summary",

            "PM1_TEMP_DE" => returnData("temperature_a", "1")->toArray(),
            "PM1_TEMP_NDE" => returnData("temperature_d", "1")->toArray(),
            "PM1_VIBRATION_DE" => returnData("vibration_value_de", "1")->toArray(),
            "PM1_VIBRATION_NDE" => returnData("vibration_value_nde", "1")->toArray(),
            "PM2_TEMP_DE" => returnData("temperature_a", "2")->toArray(),
            "PM2_TEMP_NDE" => returnData("temperature_d", "2")->toArray(),
            "PM2_VIBRATION_DE" => returnData("vibration_value_de", "2")->toArray(),
            "PM2_VIBRATION_NDE" => returnData("vibration_value_nde", "2")->toArray(),
            "PM3_TEMP_DE" => returnData("temperature_a", "3")->toArray(),
            "PM3_TEMP_NDE" => returnData("temperature_d", "3")->toArray(),
            "PM3_VIBRATION_DE" => returnData("vibration_value_de", "3")->toArray(),
            "PM3_VIBRATION_NDE" => returnData("vibration_value_nde", "3")->toArray(),
            "PM5_TEMP_DE" => returnData("temperature_a", "5")->toArray(),
            "PM5_TEMP_NDE" => returnData("temperature_d", "5")->toArray(),
            "PM5_VIBRATION_DE" => returnData("vibration_value_de", "5")->toArray(),
            "PM5_VIBRATION_NDE" => returnData("vibration_value_nde", "5")->toArray(),
            "PM7_TEMP_DE" => returnData("temperature_a", "7")->toArray(),
            "PM7_TEMP_NDE" => returnData("temperature_d", "7")->toArray(),
            "PM7_VIBRATION_DE" => returnData("vibration_value_de", "7")->toArray(),
            "PM7_VIBRATION_NDE" => returnData("vibration_value_nde", "7")->toArray(),
            "PM8_TEMP_DE" => returnData("temperature_a", "8")->toArray(),
            "PM8_TEMP_NDE" => returnData("temperature_d", "8")->toArray(),
            "PM8_VIBRATION_DE" => returnData("vibration_value_de", "8")->toArray(),
            "PM8_VIBRATION_NDE" => returnData("vibration_value_nde", "8")->toArray(),
            "WWT_TEMP_DE" => [],
            "WWT_TEMP_NDE" => [],
            "WWT_VIBRATION_DE" => [],
            "WWT_VIBRATION_NDE" => [],
            "ENC_TEMP_DE" => [],
            "ENC_TEMP_NDE" => [],
            "ENC_VIBRATION_DE" => [],
            "ENC_VIBRATION_NDE" => [],
        ]);
    }

    // UPDATE EQUIPMENT
    public function editEquipment(Request $request, string $equipment)
    {
        $emo = Emo::query()->with("emoDetails")
            ->where("id", "=", $equipment)
            ->first();

        if ($emo != null) {
            return response()->view("maintenance.edit-equipment", [
                "title" => "Edit Equipment",
                "emo" => $emo->toArray(),
            ]);
        } else {
            return response()->view("utility.page-not-found", [
                "title" => "Oops!"
            ]);
        }
    }

    public function updateEquipment(Request $request)
    {
        $request->merge([
            "updated_at" => Carbon::now()->toDateTimeString()
        ]);

        $data = $request->except(['_token']);

        // return response()->json($data);

        foreach ($data as $key => $value) {
            if (
                $key == "id" ||
                $key == "funcloc" ||
                $key == "material_number" ||
                $key == "equipment_description" ||
                $key == "status" ||
                $key == "sort_field" ||
                $key == "updated_at"
            ) {
                try {
                    Emo::query()->where("id", $data["id"])->update([$key => $value]);
                } catch (QueryException $error) {
                    return redirect()->back()->with("message", $error->getMessage() . " ⚠️");
                }
            } else {
                try {
                    EmoDetail::query()->where("emo_detail", $data["id"])->update([$key => $value]);
                } catch (QueryException $error) {
                    return redirect()->back()->with("message", $error->getMessage() . " ⚠️");
                }
            }
        }

        return redirect()->back()->with("message", "Your changes have been successfully saved! ✅");
    }
}
