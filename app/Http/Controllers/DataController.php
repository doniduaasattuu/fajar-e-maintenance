<?php

namespace App\Http\Controllers;

use App\Models\EmoRecord;
use App\Models\Emo;
use App\Models\EmoDetail;
use App\Models\FunctionLocation;
use App\Models\TransformerDetail;
use App\Models\TransformerRecord;
use App\Models\Transformers;
use App\Models\User;
use Carbon\Carbon;
use Exception;
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
use Illuminate\Support\Facades\Session;

use function Laravel\Prompts\search;
use function Laravel\Prompts\select;
use function PHPUnit\Framework\isEmpty;
use function PHPUnit\Framework\isNull;
use function PHPUnit\Framework\returnCallback;

class DataController extends Controller
{
    // ===============================================
    // ============== UTILITY FUNCTIONS ==============
    // ===============================================
    // PAGE NOT FOUND
    private function pageNotFound()
    {
        return response()->view("utility.page-not-found", [
            "title" => "Oops!"
        ], 404);
    }

    // GET TYPE OF EQUIPMENT
    private function getTypeOfEquipment(Collection $equipments): array
    {
        $type_of_equipment = [];
        foreach ($equipments as $equipment) {
            array_push($type_of_equipment, preg_replace('/[0-9]/i', '', $equipment->id));
        }
        return $type_of_equipment;
    }

    // GET TABLE COLUMNS
    public function getTableColumns($table)
    {
        return DB::getSchemaBuilder()->getColumnListing($table);
    }

    // EMO TREND
    private function renderEmoTrend($emo_records, $comments, $equipment)
    {
        return response()->view("maintenance.emos.trends", [
            "title" => $equipment == "" ? "Sort Field Trend" : "Equipment Trend",
            "sort_field" => $equipment == "" ? $emo_records[0]->sort_field : $equipment,
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

            "comments" => $comments->toArray(),
            "checked_by" => $this->returnColumnDataRecords("nik", $emo_records),
        ]);
    }

    // TRANSFORMER TREND
    private function renderTransformerTrend($transformer_records, $comments, $equipment)
    {
        return response()->view("maintenance.transformers.trends", [
            "title" => "Sort Field",
            "sort_field" => $equipment == "" ? $transformer_records[0]->sort_field : $equipment,
            "date_category" => $this->returnColumnDataRecords("created_at", $transformer_records),
            "transformer_status" => $this->returnColumnDataRecords("transformer_status", $transformer_records),
            "primary_current_phase_r" => $this->returnColumnDataRecords("primary_current_phase_r", $transformer_records),
            "primary_current_phase_s" => $this->returnColumnDataRecords("primary_current_phase_s", $transformer_records),
            "primary_current_phase_t" => $this->returnColumnDataRecords("primary_current_phase_t", $transformer_records),
            "secondary_current_phase_r" => $this->returnColumnDataRecords("secondary_current_phase_r", $transformer_records),
            "secondary_current_phase_s" => $this->returnColumnDataRecords("secondary_current_phase_s", $transformer_records),
            "secondary_current_phase_t" => $this->returnColumnDataRecords("secondary_current_phase_t", $transformer_records),
            "primary_voltage" => $this->returnColumnDataRecords("primary_voltage", $transformer_records),
            "secondary_voltage" => $this->returnColumnDataRecords("secondary_voltage", $transformer_records),
            "oil_temperature" => $this->returnColumnDataRecords("oil_temperature", $transformer_records),
            "winding_temperature" => $this->returnColumnDataRecords("winding_temperature", $transformer_records),
            "clean_status" => $this->returnColumnDataRecords("clean_status", $transformer_records),
            "noise" => $this->returnColumnDataRecords("noise", $transformer_records),
            "silica_gel" => $this->returnColumnDataRecords("silica_gel", $transformer_records),
            "earthing_connection" => $this->returnColumnDataRecords("earthing_connection", $transformer_records),
            "oil_leakage" => $this->returnColumnDataRecords("oil_leakage", $transformer_records),
            "oil_level" => $this->returnColumnDataRecords("oil_level", $transformer_records),
            "blower_condition" => $this->returnColumnDataRecords("blower_condition", $transformer_records),
            "comments" => $comments->toArray(),
            "checked_by" => $this->returnColumnDataRecords("nik", $transformer_records),
        ]);
    }

    // ===============================================
    // ================ CHECKING FORM ================
    // ===============================================
    public function getEquipmentCheckingForm(Request $request, string $equipment_id)
    {

        // equipment_id = Fajar-[Motor/Trafo]List-[0-9] eg. Fajar-TrafoList1, Fajar-MotorList1804
        $equipment_list = preg_replace('/[0-9]/i', '', $equipment_id); // Fajar-MotorList / Fajar-TrafoList

        if ($equipment_list === "Fajar-MotorList") {

            $qr_code_link = "https://www.safesave.info/MIC.php?id=" . $equipment_id;
            $emo = Emo::query()->with("emoDetails")->where("qr_code_link", "=", $qr_code_link)->first();

            if (!is_null($emo)) {

                return response()->view("maintenance.emos.checking-form", [
                    "title" => "Checking Form",
                    "emo" => $emo,
                    "equipment_id" => $equipment_id,
                ]);
            } else {
                return $this->pageNotFound();
            }
        } else if ($equipment_list === "Fajar-TrafoList") {

            $uri = "id=" . $equipment_id;
            $transformer = Transformers::query()->with("transformerDetails")->where("qr_code_link", "=", $uri)->first();

            if (!is_null($transformer)) {

                return response()->view("maintenance.transformers.checking-form", [
                    "title" => "Checking Form",
                    "transformer" => $transformer,
                    "equipment_id" => $equipment_id,
                ]);
            } else {
                return $this->pageNotFound();
            }
        } else if ($equipment_list === "Fajar-PanelList") {
            // Fajar-PanelList
            $panelList = $equipment_id;
        } else {
            return $this->pageNotFound();
        }
    }

    // ========================================
    // ================ SEARCH ================
    // ========================================
    public function search(Request $request)
    {
        $search_data = $request->input("search_data");

        // TYPE OF MOTOR
        $emos_id = Emo::query()->select(['id'])->distinct('id')->get();
        $transformers_id = Transformers::query()->select(['id'])->distinct('id')->get();

        $type_of_motor = array_unique($this->getTypeOfEquipment($emos_id));
        $type_of_trafo = array_unique($this->getTypeOfEquipment($transformers_id));

        if (
            !empty($search_data) &&
            !is_null($search_data) &&
            strlen($search_data) > 9 &&
            substr($search_data, 0, 5) === "Fajar"
        ) {
            // Fajar-XXXList format
            $redirected = action([DataController::class, "getEquipmentCheckingForm"], [
                "equipment_id" => $search_data
            ]);

            return redirect($redirected);
        } else if (
            !empty($search_data) &&
            !is_null($search_data) &&
            strlen($search_data) == 9 &&
            in_array(strtoupper(substr($search_data, 0, 3)), $type_of_motor)
        ) {
            // Equipment format
            $emo = Emo::query()->find($search_data);
            if (!is_null($emo)) {

                $qr_code_link = $emo->qr_code_link;
                $motorList = (explode("=", $qr_code_link))[1];

                $redirected = action([DataController::class, "getEquipmentCheckingForm"], [
                    "equipment_id" => $motorList
                ]);

                return redirect($redirected);
            } else {
                return $this->pageNotFound();
            }
        } else if (
            !empty($search_data) &&
            !is_null($search_data) &&
            strlen($search_data) == 9 &&
            in_array(strtoupper(substr($search_data, 0, 3)), $type_of_trafo)
        ) {
            // Equimpent format
            $etf = Transformers::query()->find($search_data);
            if (!is_null($etf)) {

                $qr_code_link = $etf->qr_code_link;
                $trafoList = (explode("=", $qr_code_link))[1];

                $redirected = action([DataController::class, "getEquipmentCheckingForm"], [
                    "equipment_id" => $trafoList
                ]);

                return redirect($redirected);
            } else {
                return $this->pageNotFound();
            }
        } else {
            return $this->pageNotFound();
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

    public function equipmentTrends(Request $request)
    {
        $sort_field = $request->input("sort_field");
        $funcloc = $request->input("funcloc");
        $equipment_id = $request->input("equipment_id");
        $equipment_list = preg_replace("/[0-9]/i", "", $equipment_id);

        if ($equipment_list == "Fajar-MotorList") {

            // EQUIPMENT MOTOR
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

                if ($emo_records->isNotEmpty()) {

                    return $this->renderEmoTrend($emo_records, $comments, "");
                } else {
                    return Redirect::back()->with('message', 'Record not found.');
                }
            } else {
                return Redirect::back()->with('message', 'Record not found.');
            }
        } else if ($equipment_list == "Fajar-TrafoList") {

            // EQUIPMENT TRAFO
            if (!is_null($sort_field) && !empty($sort_field) && !is_null($funcloc) && !empty($funcloc)) {
                $end_date = Carbon::now()->addDays(1);
                $start_date = Carbon::now()->addYears(-1)->addDays(-1);

                $transformer_records = TransformerRecord::query()
                    ->where("funcloc", "=", $funcloc)
                    ->where("sort_field", "=", $sort_field)
                    ->whereBetween("created_at", [$start_date, $end_date])
                    ->get();
                $comments = TransformerRecord::query()->with(['user' => function ($query) {
                    $query->select('nik', 'fullname');
                }])
                    ->select(["comment", "transformer", "created_at", "nik"])
                    ->where("sort_field", "=", $sort_field)
                    ->where("comment", "!=", null)
                    ->whereBetween("created_at", [$start_date, $end_date])
                    ->orderBy("created_at", "DESC")
                    ->get();

                if ($transformer_records->isNotEmpty()) {

                    return $this->renderTransformerTrend($transformer_records, $comments, "");
                } else {
                    return Redirect::back()->with('message', 'Record not found.');
                }
            } else {
                return Redirect::back()->with('message', 'Record not found.');
            }
        } else {
            return Redirect::back()->with('message', 'Record not found.');
        }
    }

    // ============================================================
    // ================ SAVE DATA RECORD EQUIPMENT ================
    // ============================================================
    public function saveDataRecordEquipment(Request $request)
    {
        $request->merge([
            "nik" => session("nik"),
            "created_at" => Carbon::now()->toDateTimeString(),
        ]);

        $data = $request->input();
        $equipment_list = preg_replace('/[0-9]/i', '', $data["equipment_id"]);

        if ($equipment_list == "Fajar-MotorList") {
            // EQUIPMENT MOTOR

            if (
                !empty($data["funcloc"]) &&
                !empty($data["emo"]) &&
                !empty($data["sort_field"]) &&
                !empty($data["equipment_id"]) &&
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
            } else {
                return response()->json([
                    "error" => "All field is required! ⚠️"
                ]);
            }
        } else if ($equipment_list == "Fajar-TrafoList") {

            // EQUIPMENT TRAFO
            if (
                !empty($data["funcloc"]) &&
                !empty($data["transformer"]) &&
                !empty($data["sort_field"]) &&
                !empty($data["equipment_id"]) &&
                !empty($data["transformer_status"]) &&
                !empty($data["clean_status"]) &&
                !empty($data["noise"]) &&
                !empty($data["silica_gel"]) &&
                !empty($data["earthing_connection"]) &&
                !empty($data["oil_leakage"]) &&
                !empty($data["oil_level"]) &&
                !empty($data["blower_condition"])
            ) {
                try {

                    foreach ($data as $key => $value) {
                        if ($value == null) {
                            if ($key != "comment") {
                                $data[$key] = 0;
                            }
                        }
                    }

                    $transformer_record = TransformerRecord::create($data);
                    $result = $transformer_record->save();
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
            } else {
                return response()->json([
                    "error" => "All field is required! ⚠️"
                ]);
            }
        } else {
            return $this->pageNotFound();
        }
    }


    // ===================================================
    // ================ EMO TRENDS PICKER ================
    // ===================================================
    public function trendsPicker()
    {
        return response()->view("maintenance.trends-picker", [
            "title" => "Trends picker",
        ]);
    }

    // ============================================
    // ============= EMO, ETF TRENDS ==============
    // ============================================
    public function trendsRender(Request $request)
    {
        $equipment = $request->input("equipment");
        $equipment_code = preg_replace('/[0-9]/i', '', $equipment);
        $end_date = !is_null($request->input("end_date")) ? $request->input("end_date") : Carbon::now()->addDays(1);
        $start_date = !is_null($request->input("start_date")) ? $request->input("start_date") : Carbon::now()->addYears(-1)->addDays(-1);

        $emos_id = Emo::query()->select(['id'])->distinct('id')->get();
        $transformers_id = Transformers::query()->select(['id'])->distinct('id')->get();

        $type_of_motor = array_unique($this->getTypeOfEquipment($emos_id));
        $type_of_trafo = array_unique($this->getTypeOfEquipment($transformers_id));

        if (in_array(strtoupper($equipment_code), $type_of_motor)) {

            // EMO
            $emo_records = EmoRecord::whereBetween("created_at", [$start_date, $end_date])->where("emo", "=", $equipment)->get();

            if ($emo_records->isNotEmpty()) {

                $comments = EmoRecord::query()
                    ->with(['user' => function ($query) {
                        $query->select('nik', 'fullname');
                    }])
                    ->select(["comment", "emo", "created_at", "nik"])
                    ->where("emo", "=", $equipment)
                    ->where("comment", "!=", null)
                    ->whereBetween("created_at", [$start_date, $end_date])
                    ->orderBy("created_at", "DESC")
                    ->get();

                return $this->renderEmoTrend($emo_records, $comments, $emo_records[0]->emo);
            } else {
                return redirect()->back()->with("message", "Record not found.");
            }
        } else if (in_array(strtoupper($equipment_code), $type_of_trafo)) {

            // ETF
            $transformer_records = TransformerRecord::whereBetween("created_at", [$start_date, $end_date])->where("transformer", "=", $equipment)->get();

            if ($transformer_records->isNotEmpty()) {

                $comments = TransformerRecord::query()
                    ->with(['user' => function ($query) {
                        $query->select('nik', 'fullname');
                    }])
                    ->select(["comment", "transformer", "created_at", "nik"])
                    ->where("transformer", "=", $equipment)
                    ->where("comment", "!=", null)
                    ->whereBetween("created_at", [$start_date, $end_date])
                    ->orderBy("created_at", "DESC")
                    ->get();

                return $this->renderTransformerTrend($transformer_records, $comments, $transformer_records[0]->transformer);
            } else {
                return redirect()->back()->with("message", "Record not found.");
            }
        } else {
            return $this->pageNotFound();
        }
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
    public function editEquipment(Request $request)
    {
        $equipment = $request->input("equipment");
        $equipment_details = $request->input("equipment_details");

        $equipment_code = preg_replace('/[0-9]/i', '', $equipment); // EMO / ETF

        $emos_id = Emo::query()->select(['id'])->distinct('id')->get();
        $transformers_id = Transformers::query()->select(['id'])->distinct('id')->get();

        $type_of_motor = array_unique($this->getTypeOfEquipment($emos_id));
        $type_of_trafo = array_unique($this->getTypeOfEquipment($transformers_id));

        if (in_array(strtoupper($equipment_code), $type_of_motor)) {

            if ($equipment_details) {
                $emo = Emo::query()->with("emoDetails")->find($equipment);
            } else {
                $emo = Emo::query()->find($equipment);
            }

            if (!is_null($emo)) {
                return response()->view("maintenance.edit-equipment", [
                    "title" => "Edit Equipment",
                    "equipment" => $emo,
                ]);
            } else {
                return response()->view("maintenance.search-equipment", [
                    'title' => "Search equipment",
                    'message' => "Equipment not found."
                ]);
            }
        } else if (in_array(strtoupper($equipment_code), $type_of_trafo)) {

            if ($equipment_details) {
                $transformer = Transformers::query()->with("transformerDetails")->find($equipment);
            } else {
                $transformer = Transformers::query()->find($equipment);
            }

            if (!is_null($transformer)) {
                return response()->view("maintenance.edit-equipment", [
                    "title" => "Edit Equipment",
                    "equipment" => $transformer,
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

        $table = $request->input('table');
        $data = $request->except(['_token', 'table']);

        // return response()->json($data);

        DB::beginTransaction();
        foreach ($data as $key => $value) {
            if (
                $key == "id" ||
                $key == "status" ||
                $key == "funcloc" ||
                $key == "sort_field" ||
                $key == "material_number" ||
                $key == "equipment_description" ||
                $key == "updated_at"
            ) {
                try {
                    if ($table == 'emos') {
                        Emo::query()->where("id", $data["id"])->update([$key => $value]);
                    } else if ($table == 'transformers') {
                        Transformers::query()->where("id", $data["id"])->update([$key => $value]);
                    } else {
                        throw new Exception("Table is not defined!.");
                    }
                } catch (Exception $error) {
                    DB::rollBack();
                    return redirect()->route("searchEquipment", ['title' => 'Search Equipment'])->with("message", $error->getMessage() . " ⚠️");
                }
            } else {
                try {
                    if ($table == 'emos') {
                        EmoDetail::query()->where("emo_detail", $data["id"])->update([$key => $value]);
                    } else if ($table == 'transformers') {
                        TransformerDetail::query()->where("transformer_detail", $data["id"])->update([$key => $value]);
                    } else {
                        throw new Exception("Table is not defined!.");
                    }
                } catch (Exception $error) {
                    DB::rollBack();
                    return redirect()->route("searchEquipment", ['title' => 'Search Equipment'])->with("message", $error->getMessage() . " ⚠️");
                }
            }
        }
        DB::commit();

        return redirect()->route("searchEquipment", ['title' => 'Search Equipment'])->with("message", "Your changes have been successfully saved! ✅");
    }

    // ============================================
    // =============== EMO DATALIST ===============
    // ============================================
    public function emoDatalist()
    {
        $emo_list = EmoRecord::query()->select("emo")->distinct()->get();
        return response()->json($emo_list);
    }

    // ============================================
    // ================ EMO CHECK =================
    // ============================================
    public function emoCheck(Request $request)
    {
        $id = $request->input('emo');

        $emo = Emo::query()->find($id);

        if (!is_null($emo)) {
            return 'Equipment is already registered';
        }
    }

    // ============================================
    // ============== UNIQUE ID CHECK =============
    // ============================================
    public function uniqueIdCheck(Request $request)
    {
        $unique_id = $request->input('unique_id');

        $emo = Emo::query()->where('unique_id', '=', $unique_id)->first();

        if (!is_null($emo)) {
            return 'Unique id is already registered';
        }
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
    }

    // ==================================================
    // ================ REGISTRY FUNCLOC ================
    // ==================================================
    public function registryFuncloc()
    {
        $funcloc_table = DB::getSchemaBuilder()->getColumnListing('function_locations');

        return response()->view("maintenance.registry-funcloc", [
            'title' => "Registry Funcloc",
            'funcloc_table' => $funcloc_table,
        ]);
    }

    // ==================================================
    // ================ REGISTRY FUNCLOC ================
    // ==================================================
    public function registerFuncloc(Request $request)
    {
        $request->merge(['created_at' => Carbon::now()->toDateTimeString()]);
        $data = $request->except(['_token']);

        if (substr($data['id'], 0, 6) !== 'FP-01-') {
            return redirect()->back()->with('message', 'Funcloc is invalid!');
        }
        // return response()->json($data);

        DB::beginTransaction();

        try {

            FunctionLocation::query()->insert($data);

            DB::commit();

            return redirect()->back()->with('message', 'Success');
        } catch (QueryException $error) {
            DB::rollBack();
            return redirect()->back()->with('message', $error->errorInfo[2]);
        }
        // return response()->json($data);
    }

    // ==================================================
    // ================= CHECK FUNCLOC ==================
    // ==================================================
    public function funclocCheck(Request $request)
    {
        $funcloc = $request->input('funcloc');

        $function_location = FunctionLocation::query()->find($funcloc);

        if (is_null($function_location)) {
            return 'Funcloc is exist';
        } else {
            return 'Funcloc is not exist';
        }
    }


    // ==================================================
    // ================= REGISTRY MOTOR =================
    // ==================================================
    public function registryMotor()
    {
        $emos_column = DB::getSchemaBuilder()->getColumnListing('emos');
        $emo_details_column = DB::getSchemaBuilder()->getColumnListing('emo_details');

        $columns = array_merge($emos_column, $emo_details_column);

        // return response()->json($columns);

        return response()->view("maintenance.registry-motor", [
            'title' => "Registry Motor",
            'columns' => $columns,
        ]);
    }

    public function registerMotor(Request $request)
    {
        $request->merge(['created_at' => Carbon::now()->toDateTimeString()]);
        $data = $request->except(['_token']);

        if (substr($data['id'], 0, 6) !== 'FP-01-') {
            return redirect()->back()->with('message', 'Funcloc is invalid!');
        }
        // return response()->json($data);

        DB::beginTransaction();

        if (substr($data['id'], 0, 6) === 'FP-01-') {
            try {

                FunctionLocation::query()->insert($data);

                DB::commit();

                return redirect()->back()->with('message', 'Success');
            } catch (QueryException $error) {
                DB::rollBack();
                return redirect()->back()->with('message', $error->errorInfo[2]);
            }
        } else {
            return redirect()->back()->with('message', 'Funcloc is invalid!');
        }
    }
}
