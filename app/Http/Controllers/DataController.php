<?php

namespace App\Http\Controllers;

use App\Models\Emo;
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

    public function saveData()
    {
    }
}
