<?php

namespace App\Http\Controllers;

use App\Models\Emo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class DataController extends Controller
{
    public function getForm(Request $request, string $motorList)
    {

        $uri = "https://www.safesave.info/MIC.php?id=" . $motorList;
        $emo = Emo::query()->with("funcLoc", "emoDetail")->where("qr_code_link", "=", $uri)->first();

        return view("maintenance.checking-form", [
            "title" => "Checking Form",
            "emo" => $emo,
            "funcLoc" => $emo->funcLoc->toArray(),
            "emoDetail" => $emo->emoDetail->toArray(),
        ]);
    }

    public function saveData()
    {
    }
}
