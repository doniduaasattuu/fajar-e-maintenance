<?php

namespace App\Http\Controllers;

use App\Models\EmoRecord;
use App\Models\Emo;
use App\Models\EmoDetail;
use App\Models\Transformers;
use App\Models\User;
use Carbon\Carbon;
use Ghunti\HighchartsPHP\Highchart;
use Ghunti\HighchartsPHP\HighchartJsExpr;
use Illuminate\Database\Eloquent\Collection;
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
    // ===============================================
    // ================ CHECKING FORM ================
    // ===============================================
    public function getCheckingForm(Request $request, string $equipment)
    {
        // EQUIPMENT CHECK (EMO / ELP / ETF / etc)
        $equipment_code = substr($equipment, 0, 15); // Fajar-MotorList, Fajar-TrafoList, Fajar-PanelList, etc.

        if ($equipment_code === "Fajar-MotorList") {
            $motorList = $equipment;
            $uri = "https://www.safesave.info/MIC.php?id=" . $motorList;
            $emo = Emo::query()->with("emoDetails")->where("qr_code_link", "=", $uri)->first();

            if (!is_null($emo)) {

                return response()->view("maintenance.emos.checking-form", [
                    "title" => "Checking Form",
                    "emo" => $emo,
                    "emoDetail" => $emo->emoDetails->toArray(),
                    "motorList" => $motorList,
                ]);
            } else {
                return response()->view("utility.page-not-found", [
                    "title" => "Oops!"
                ]);
            }
        } else if ($equipment_code === "Fajar-TrafoList") {
            // Fajar-TrafoList
            $trafoList = $equipment;
            $uri = "id=" . $trafoList;
            $transformer = Transformers::query()->with("transformerDetails")->where("qr_code_link", "=", $uri)->first();

            if (!is_null($transformer)) {

                return response()->view("maintenance.transformers.checking-form", [
                    "title" => "Checking Form",
                    "transformer" => $transformer,
                    "transformerDetail" => $transformer->transformerDetails->toArray(),
                    "trafoList" => $trafoList,
                ]);
            } else {
                return response()->view("utility.page-not-found", [
                    "title" => "Oops!"
                ]);
            }
        } else if ($equipment_code === "Fajar-PanelList") {
            // Fajar-PanelList
            $panelList = $equipment;
        } else {
            return response()->view("utility.page-not-found", [
                "title" => "Oops!"
            ]);
        }
    }

    // ========================================
    // ================ SEARCH ================
    // ========================================
    public function search(Request $request)
    {
        $search_data = $request->input("search_data");

        if (!empty($search_data) && !is_null($search_data) && strlen($search_data) > 9 && substr($search_data, 0, 5) === "Fajar") {
            // Fajar-XXXList
            $redirected = action([DataController::class, "getCheckingForm"], [
                "equipment" => $search_data
            ]);

            return redirect($redirected);
        } else if (
            !empty($search_data) &&
            !is_null($search_data) &&
            strlen($search_data) == 9 &&
            (substr($search_data, 0, 3) == "EMO" ||
                substr($search_data, 0, 3) == "MGM" ||
                substr($search_data, 0, 3) == "MGB" ||
                substr($search_data, 0, 3) == "MFB" ||
                substr($search_data, 0, 3) == "MDO")
        ) {
            // Equimpent format
            $emo = Emo::query()->find($search_data);
            if (!is_null($emo)) {

                $qr_code_link = $emo->qr_code_link;
                $motorList = (explode("=", $qr_code_link))[1];

                $redirected = action([DataController::class, "getCheckingForm"], [
                    "equipment" => $motorList
                ]);

                return redirect($redirected);
            } else {
                return response()->view("utility.page-not-found", [
                    "title" => "Oops!"
                ]);
            }
        } else if (
            !empty($search_data) &&
            !is_null($search_data) &&
            strlen($search_data) == 9 &&
            substr($search_data, 0, 3) == "ETF"
        ) {
            // Equimpent format
            $etf = Transformers::query()->find($search_data);
            if (!is_null($etf)) {

                $qr_code_link = $etf->qr_code_link;
                $trafoList = (explode("=", $qr_code_link))[1];

                $redirected = action([DataController::class, "getCheckingForm"], [
                    "equipment" => $trafoList
                ]);

                return redirect($redirected);
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

    // ==================================================
    // ================ SORTFIELD TRENDS ================
    // ==================================================
    private function returnColumnDataRecords(string $columnName, Collection $emo_records)
    {
        $result = [];
        if ($columnName == "nik") {
            foreach ($emo_records as $record) {
                array_push($result, User::query()->find($record->$columnName)->fullname);
            }
        } else if ($columnName == "created_at") {
            foreach ($emo_records as $record) {
                array_push($result, date_format(date_create($record->$columnName), "d/m/y"));
            }
        } else {
            foreach ($emo_records as $record) {
                array_push($result, $record->$columnName);
            }
        }
        return $result;
    }

    public function sortFieldMotorTrends(Request $request)
    {
        $sort_field = $request->input("sort_field");
        $funcloc = $request->input("funcloc");

        if (!is_null($sort_field) && !empty($sort_field) && !is_null($funcloc) && !empty($funcloc)) {
            $end_date = Carbon::now()->addDays(1);
            $start_date = Carbon::now()->addYears(-1)->addDays(-1);

            $emo_records = EmoRecord::query()
                ->where("funcloc", "=", $funcloc)
                ->where("sort_field", "=", $sort_field)
                ->whereBetween("created_at", [$start_date, $end_date])
                ->get();
            $comments = EmoRecord::query()->with(['user' => function ($query) {
                $query->select('nik', 'fullname');
            }])
                ->select(["comment", "emo", "created_at", "nik"])
                ->where("sort_field", "=", $sort_field)
                ->where("comment", "!=", null)
                ->whereBetween("created_at", [$start_date, $end_date])
                ->orderBy("created_at", "DESC")
                ->get();

            if (!is_null($emo_records)) {

                return response()->view("maintenance.sortfield-trends", [
                    "title" => "Sort Field",
                    "sort_field" => $sort_field,
                    "date_category" => $this->returnColumnDataRecords("created_at", $emo_records),
                    "motor_status" => $this->returnColumnDataRecords("motor_status", $emo_records),
                    "number_of_greasing" => $this->returnColumnDataRecords("number_of_greasing", $emo_records),
                    "temperature_de" => $this->returnColumnDataRecords("temperature_de", $emo_records),
                    "temperature_body" => $this->returnColumnDataRecords("temperature_body", $emo_records),
                    "temperature_nde" => $this->returnColumnDataRecords("temperature_nde", $emo_records),

                    "vibration_de_vertical_value" => $this->returnColumnDataRecords("vibration_de_vertical_value", $emo_records),
                    "vibration_de_vertical_desc" => $this->returnColumnDataRecords("vibration_de_vertical_desc", $emo_records),

                    "vibration_de_horizontal_value" => $this->returnColumnDataRecords("vibration_de_horizontal_value", $emo_records),
                    "vibration_de_horizontal_desc" => $this->returnColumnDataRecords("vibration_de_horizontal_desc", $emo_records),

                    "vibration_de_axial_value" => $this->returnColumnDataRecords("vibration_de_axial_value", $emo_records),
                    "vibration_de_axial_desc" => $this->returnColumnDataRecords("vibration_de_axial_desc", $emo_records),

                    "vibration_de_frame_value" => $this->returnColumnDataRecords("vibration_de_frame_value", $emo_records),
                    "vibration_de_frame_desc" => $this->returnColumnDataRecords("vibration_de_frame_desc", $emo_records),

                    "noise_de" => $this->returnColumnDataRecords("noise_de", $emo_records),

                    "vibration_nde_vertical_value" => $this->returnColumnDataRecords("vibration_nde_vertical_value", $emo_records),
                    "vibration_nde_vertical_desc" => $this->returnColumnDataRecords("vibration_nde_vertical_desc", $emo_records),

                    "vibration_nde_horizontal_value" => $this->returnColumnDataRecords("vibration_nde_horizontal_value", $emo_records),
                    "vibration_nde_horizontal_desc" => $this->returnColumnDataRecords("vibration_nde_horizontal_desc", $emo_records),

                    "vibration_nde_frame_value" => $this->returnColumnDataRecords("vibration_nde_frame_value", $emo_records),
                    "vibration_nde_frame_desc" => $this->returnColumnDataRecords("vibration_nde_frame_desc", $emo_records),

                    "noise_nde" => $this->returnColumnDataRecords("noise_nde", $emo_records),

                    // "temperature_a" => $this->returnColumnDataRecords("temperature_a", $emo_records),
                    // "temperature_b" => $this->returnColumnDataRecords("temperature_b", $emo_records),
                    // "temperature_c" => $this->returnColumnDataRecords("temperature_c", $emo_records),
                    // "temperature_d" => $this->returnColumnDataRecords("temperature_d", $emo_records),
                    // "vibration_value_de" => $this->returnColumnDataRecords("vibration_value_de", $emo_records),
                    // "vibration_de" => $this->returnColumnDataRecords("vibration_de", $emo_records),
                    // "vibration_value_nde" => $this->returnColumnDataRecords("vibration_value_nde", $emo_records),
                    // "vibration_nde" => $this->returnColumnDataRecords("vibration_nde", $emo_records),
                    "comments" => $comments->toArray(),
                    "checked_by" => $this->returnColumnDataRecords("nik", $emo_records),
                ]);
            } else {
                return Redirect::back();
            }
        } else {
            return Redirect::back();
        }
    }

    // =================================================
    // ================ SAVE DATA MOTOR ================
    // =================================================
    public function saveDataMotor(Request $request)
    {
        $request->merge([
            "nik" => session("nik"),
            "updated_at" => Carbon::now()->toDateTimeString()
        ]);

        $data = $request->input();

        // return response()->json($data["noise_de"]);

        if (
            !empty($data["funcloc"]) &&
            !empty($data["emo"]) &&
            !empty($data["sort_field"]) &&
            !empty($data["motor_status"]) &&
            !empty($data["clean_status"]) &&
            !empty($data["nipple_grease"]) &&
            !empty($data["noise_de"]) &&
            !empty($data["noise_nde"])
        ) {
            try {

                foreach ($data as $key => $value) {
                    if ($value == null) {
                        if ($key != "comment" && ("desc" != substr($key, -4))) {
                            $data[$key] = 0;
                        }
                    }
                }

                // return response()->json($data);
                $emo_record = EmoRecord::create($data);
                $result = $emo_record->save();
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

            // if ($result == true) {
            //     return response()->json([
            //         "message" => "Saved successfully! ✅"
            //     ]);
            // } else {
            //     return response()->json([
            //         "error" => "Error saving record! ⚠️"
            //     ]);
            // }
        } else {
            return response()->json([
                "error" => "All field is required! ⚠️"
            ]);
        }


        // $funcloc = $request->input("funcloc");
        // $collection->eachSpread(function (string $id, string $value) {
        //     // return response()->json(json_encode($id));
        // });
        // var_dump();

        // $funcloc = $request->input("funcloc");
        // return response()->json(json_encode($funcloc));

        // $funcloc = $request->input("funcloc");
        // $emo = $request->input("emo");
        // $sort_field = $request->input("sort_field");
        // $motor_status = $request->input("motor_status");
        // $clean_status = $request->input("clean_status");
        // $nipple_grease_input = $request->input("nipple_grease_input");
        // $number_of_greasing_input = ($request->input("number_of_greasing_input") != null) ? $request->input("number_of_greasing_input") : 0;
        // $temperature_a = ($request->input("temperature_a") != null) ? $request->input("temperature_a") : 0;
        // $temperature_b = ($request->input("temperature_b") != null) ? $request->input("temperature_b") : 0;
        // $temperature_c = ($request->input("temperature_c") != null) ? $request->input("temperature_c") : 0;
        // $temperature_d = ($request->input("temperature_d") != null) ? $request->input("temperature_d") : 0;
        // $vibration_value_de = ($request->input("vibration_value_de") != null) ? $request->input("vibration_value_de") : 0;
        // $vibration_de = $request->input("vibration_de");
        // $vibration_value_nde = ($request->input("vibration_value_nde") != null) ? $request->input("vibration_value_nde") : 0;
        // $vibration_nde = $request->input("vibration_nde");
        // $comment = $request->input("comment");
        // $nik = session("nik");

        // if (
        //     empty($funcloc) ||
        //     empty($emo) ||
        //     empty($sort_field) ||
        //     empty($motor_status) ||
        //     empty($clean_status) ||
        //     empty($nipple_grease_input)
        // ) {
        //     return response()->json([
        //         "error" => "All field is required! ⚠️"
        //     ]);
        // } else {

        //     try {
        //         $data_record = new EmoRecord();
        //         $data_record->funcloc = $funcloc;
        //         $data_record->emo = $emo;
        //         $data_record->sort_field = $sort_field;
        //         $data_record->motor_status = $motor_status;
        //         $data_record->clean_status = $clean_status;
        //         $data_record->nipple_grease = $nipple_grease_input;
        //         $data_record->number_of_greasing = $number_of_greasing_input;
        //         $data_record->temperature_a = $temperature_a;
        //         $data_record->temperature_b = $temperature_b;
        //         $data_record->temperature_c = $temperature_c;
        //         $data_record->temperature_d = $temperature_d;
        //         $data_record->vibration_value_de = $vibration_value_de;
        //         $data_record->vibration_de = $vibration_de;
        //         $data_record->vibration_value_nde = $vibration_value_nde;
        //         $data_record->vibration_nde = $vibration_nde;
        //         $data_record->comment = $comment;
        //         $data_record->created_at = Carbon::now()->toDateTimeString();
        //         $data_record->nik = $nik;
        //         $result = $data_record->save();
        //     } catch (QueryException $error) {
        //         return response()->json([
        //             "error" => $error
        //         ]);
        //     }

        //     if ($result) {
        //         return response()->json([
        //             "message" => "Saved successfully! ✅"
        //         ]);
        //     } else { {
        //             return response()->json([
        //                 "error" => "Error occurred! ⚠️"
        //             ]);
        //         }
        //     }
        // }
    }

    // ============================================
    // ================ EMO TRENDS ================
    // ============================================
    public function trends(Request $request, string $emo)
    {
        $end_date = !is_null($request->input("end_date")) ? $request->input("end_date") : Carbon::now()->addDays(1);
        $start_date = !is_null($request->input("start_date")) ? $request->input("start_date") : Carbon::now()->addYears(-1)->addDays(-1);

        if (strlen($emo) == 9) {

            $end_date = date_format(date_create($end_date), "Y-m-d");
            $start_date = date_format(date_create($start_date), "Y-m-d");

            $emo_records = EmoRecord::query()->whereBetween("created_at", [$start_date, $end_date])->where("emo", "=", $emo)->get();
            $emo_details = EmoDetail::query()->where("emo_detail", "=", $emo)->first();

            $comments = EmoRecord::query()
                ->select(["comment", "funcloc", "nik", "created_at"])->where("comment", "!=", null)
                ->whereBetween("created_at", [$start_date, $end_date])
                ->where("emo", "=", $emo)
                ->orderBy("created_at", "DESC")
                ->get();

            if (!is_null($emo_details)) {

                $nipple_grease = $emo_details->nipple_grease;
                $date_category = [];
                $motor_status = [];
                $temperature_a = [];
                $temperature_b = [];
                $temperature_c = [];
                $temperature_d = [];
                $vibration_value_de = [];
                $vibration_de = [];
                $vibration_value_nde = [];
                $vibration_nde = [];
                $number_of_greasing = [];
                $checked_by = [];

                foreach ($emo_records as $record) {
                    $year = substr($record->created_at, 2, 2);
                    $month = substr($record->created_at, 5, 2);
                    $date = substr($record->created_at, 8, 2);
                    array_push($date_category, $date . "/" . $month . "/" . $year);

                    array_push($motor_status, $record->motor_status);

                    array_push($temperature_a, $record->temperature_a);
                    array_push($temperature_b, $record->temperature_b);
                    array_push($temperature_c, $record->temperature_c);
                    array_push($temperature_d, $record->temperature_d);

                    array_push($vibration_value_de, (float) $record->vibration_value_de);
                    array_push($vibration_value_nde, (float) $record->vibration_value_nde);

                    array_push($vibration_de, $record->vibration_de);
                    array_push($vibration_nde, $record->vibration_nde);

                    array_push($number_of_greasing, $record->number_of_greasing);

                    array_push($checked_by, User::query()->find($record->nik)->fullname);
                }

                return response()->view("maintenance.trends", [
                    "title" => "Trends",
                    "date_category" => $date_category,
                    "motor_status" => $motor_status,
                    "temperature_a" => $temperature_a,
                    "temperature_b" => $temperature_b,
                    "temperature_c" => $temperature_c,
                    "temperature_d" => $temperature_d,
                    "vibration_value_de" => $vibration_value_de,
                    "vibration_de" => $vibration_de,
                    "vibration_value_nde" => $vibration_value_nde,
                    "vibration_nde" => $vibration_nde,
                    "number_of_greasing" => $number_of_greasing,
                    "emo" => $emo,
                    "nipple_grease" => $nipple_grease,
                    "comments" => $comments->toArray(),
                    "checked_by" => $checked_by,
                ]);
            } else {

                return Redirect::back();
            }
        } else {

            return Redirect::back();
        }
    }

    // ===================================================
    // ================ EMO TRENDS PICKER ================
    // ===================================================
    public function trendsPicker()
    {
        return response()->view("maintenance.trends-picker", [
            "title" => "Trends picker",
            "header" => "Equipment trend",
        ]);
    }

    // ===================================================
    // =============== SUMMARY TOP OF FIVE ===============
    // ===================================================
    public function summary()
    {
        function returnData(string $temp_a, string $paper_machine)
        {
            $data = EmoRecord::query()
                ->select(["funcloc", "emo", $temp_a, "created_at"])
                ->orderByDesc($temp_a)
                ->where("funcloc", "LIKE", "FP-01-PM$paper_machine%")
                ->orWhere("funcloc", "LIKE", "FP-01-SP$paper_machine%")
                ->orWhere("funcloc", "LIKE", "FP-01-FN$paper_machine%")
                ->orWhere("funcloc", "LIKE", "FP-01-CH$paper_machine%")
                ->whereBetween("created_at", [Carbon::now()->addMonths(-12), Carbon::now()])
                ->limit(5)
                ->get();

            return $data;
        }

        return response()->view("maintenance.summary", [
            "title" => "Summary",

            "PM1_TEMP_DE" => returnData("temperature_de", "1")->toArray(),
            "PM1_TEMP_NDE" => returnData("temperature_nde", "1")->toArray(),
            "PM1_VIBRATION_DE" => returnData("vibration_de_axial_value", "1")->toArray(),
            "PM1_VIBRATION_NDE" => returnData("vibration_nde_vertical_value", "1")->toArray(),
            "PM2_TEMP_DE" => returnData("temperature_de", "2")->toArray(),
            "PM2_TEMP_NDE" => returnData("temperature_nde", "2")->toArray(),
            "PM2_VIBRATION_DE" => returnData("vibration_de_axial_value", "2")->toArray(),
            "PM2_VIBRATION_NDE" => returnData("vibration_nde_vertical_value", "2")->toArray(),
            "PM3_TEMP_DE" => returnData("temperature_de", "3")->toArray(),
            "PM3_TEMP_NDE" => returnData("temperature_nde", "3")->toArray(),
            "PM3_VIBRATION_DE" => returnData("vibration_de_axial_value", "3")->toArray(),
            "PM3_VIBRATION_NDE" => returnData("vibration_nde_vertical_value", "3")->toArray(),
            "PM5_TEMP_DE" => returnData("temperature_de", "5")->toArray(),
            "PM5_TEMP_NDE" => returnData("temperature_nde", "5")->toArray(),
            "PM5_VIBRATION_DE" => returnData("vibration_de_axial_value", "5")->toArray(),
            "PM5_VIBRATION_NDE" => returnData("vibration_nde_vertical_value", "5")->toArray(),
            "PM7_TEMP_DE" => returnData("temperature_de", "7")->toArray(),
            "PM7_TEMP_NDE" => returnData("temperature_nde", "7")->toArray(),
            "PM7_VIBRATION_DE" => returnData("vibration_de_axial_value", "7")->toArray(),
            "PM7_VIBRATION_NDE" => returnData("vibration_nde_vertical_value", "7")->toArray(),
            "PM8_TEMP_DE" => returnData("temperature_de", "8")->toArray(),
            "PM8_TEMP_NDE" => returnData("temperature_nde", "8")->toArray(),
            "PM8_VIBRATION_DE" => returnData("vibration_de_axial_value", "8")->toArray(),
            "PM8_VIBRATION_NDE" => returnData("vibration_nde_vertical_value", "8")->toArray(),
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

    // ==============================================
    // =============== EDIT EQUIPMENT ===============
    // ==============================================
    public function editEquipment(Request $request, string $equipment)
    {
        if (!is_null($equipment)) {

            $with_emo_details = $request->input("emo_details");

            if ($with_emo_details) {
                $emo = Emo::query()->with("emoDetails")->find($equipment);
            } else {
                $emo = Emo::query()->find($equipment);
            }

            if (!is_null($emo)) {
                return response()->view("maintenance.edit-equipment", [
                    "title" => "Edit Equipment",
                    "emo" => $emo->toArray(),
                ]);
            } else {
                return response()->view("maintenance.search-equipment", [
                    'title' => "Search equipment",
                    'message' => "Equipment not found."
                ]);
            }
        } else {
            return response()->view("maintenance.search-equipment", [
                'title' => "Search equipment",
                'message' => "Equipment not found."
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

    // ============================================
    // =============== EMO DATALIST ===============
    // ============================================
    public function emoDatalist()
    {
        $emo_list = EmoRecord::query()->select("emo")->distinct()->get();
        return response()->json($emo_list);
    }

    // ==================================================
    // ================ INSTALL DISMANTLE ===============
    // ==================================================
    public function equipment(Request $request)
    {
        $equipment = $request->input("equipment");
        $emo = Emo::query()->with("emoDetails")->find($equipment);
        return response()->json(json_encode($emo));
    }

    public function doInstalDismantle(Request $request)
    {
        $request->merge([
            "updated_at_install" => Carbon::now()->toDateTimeString(),
            "updated_at_dismantle" => Carbon::now()->toDateTimeString(),
        ]);

        $data = $request->except(['_token']);

        // $dismantle = [];
        // $install = [];

        DB::beginTransaction();

        foreach ($data as $key => $value) {
            if (str_contains($key, "_dismantle")) {

                $key_replaced = str_replace(substr($key, -10), "", $key);

                if (
                    $key_replaced == "id" ||
                    $key_replaced == "status" ||
                    $key_replaced == "funcloc" ||
                    $key_replaced == "sort_field" ||
                    $key_replaced == "material_number" ||
                    $key_replaced == "equipment_description" ||
                    $key_replaced == "updated_at"
                ) {
                    try {
                        Emo::query()->where("id", $data["id_dismantle"])->update([$key_replaced => $value]);
                    } catch (QueryException $error) {
                        DB::rollBack();
                        return redirect()->back()->with("message", $error->getMessage() . " ⚠️");
                    }
                } else {
                    try {
                        EmoDetail::query()->where("emo_detail", $data["id_dismantle"])->update([$key_replaced => $value]);
                    } catch (QueryException $error) {
                        DB::rollBack();
                        return redirect()->back()->with("message", $error->getMessage() . " ⚠️");
                    }
                }
            } else if (str_contains($key, "_install")) {

                $key_replaced = str_replace(substr($key, -8), "", $key);

                if (
                    $key_replaced == "id" ||
                    $key_replaced == "status" ||
                    $key_replaced == "funcloc" ||
                    $key_replaced == "sort_field" ||
                    $key_replaced == "material_number" ||
                    $key_replaced == "equipment_description" ||
                    $key_replaced == "updated_at"
                ) {
                    try {
                        Emo::query()->where("id", $data["id_install"])->update([$key_replaced => $value]);
                    } catch (QueryException $error) {
                        DB::rollBack();
                        return redirect()->back()->with("message", $error->getMessage() . " ⚠️");
                    }
                } else {
                    try {
                        EmoDetail::query()->where("emo_detail", $data["id_install"])->update([$key_replaced => $value]);
                    } catch (QueryException $error) {
                        DB::rollBack();
                        return redirect()->back()->with("message", $error->getMessage() . " ⚠️");
                    }
                }
            }
        }

        DB::commit();

        return redirect()->back()->with("message", "Your changes have been successfully saved! ✅");
        // var_dump($data);
        // return response()->json(json_encode($data));
        // return response()->json([$dismantle, $install]);
        // return response()->json($data);
    }
}
