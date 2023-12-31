<?php

use App\Http\Middleware\AdministratorMiddleware;
use App\Http\Middleware\OnlyGuestMiddleware;
use App\Http\Middleware\OnlyMemberMiddleware;
use Illuminate\Http\Request as HttpRequest;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::middleware(OnlyGuestMiddleware::class)->group(function () {
    Route::get("/login", [App\Http\Controllers\UserController::class, "login"])->name("login");
    Route::post("/login", [App\Http\Controllers\UserController::class, "doLogin"]);
    Route::get("/registration", [App\Http\Controllers\UserController::class, "registration"]);
    Route::post("/registration", [App\Http\Controllers\UserController::class, "register"]);
    Route::fallback(function () {
        return redirect("/");
    });
});

Route::middleware(OnlyMemberMiddleware::class)->group(function () {
    Route::fallback(function () {
        return response()->view("utility.page-not-found", [
            "title" => "Oops!"
        ], 404);
    });

    Route::get('/scanner', function () {
        return response()->view("maintenance.scanner", [
            "title" => "Scanner"
        ]);
    });

    Route::get('/', function (HttpRequest $request) {
        return response()->view("maintenance.home", [
            "title" => "Home",
            "user" => $request->session()->get("user")
        ]);
    })->name("home");

    Route::post("/search", [App\Http\Controllers\DataController::class, "search"]);

    Route::get("/logout", function (HttpRequest $request) {
        $request->session()->flush();
        return redirect("/");
    });

    // equipment_id = Fajar-[Motor/Trafo]List-[0-9] eg. Fajar-TrafoList1, Fajar-MotorList1804
    Route::get('/checking-form/{equipment_id}', [App\Http\Controllers\DataController::class, "getEquipmentCheckingForm"]);
    Route::post('/checking-form/{equipment_id}', [App\Http\Controllers\DataController::class, "saveDataRecordEquipment"]);

    Route::get('/change-name', [App\Http\Controllers\UserController::class, "changeName"]);
    Route::post('/change-name', [App\Http\Controllers\UserController::class, "doChangeName"]);

    Route::get('/change-password', [App\Http\Controllers\UserController::class, "changePassword"]);
    Route::post('/change-password', [App\Http\Controllers\UserController::class, "doChangePassword"]);

    Route::get('/trends-picker', [App\Http\Controllers\DataController::class, "trendsPicker"])->name("trendsPicker");
    Route::post('/trends-picker', [App\Http\Controllers\DataController::class, "trendsRender"]);
    Route::get('/emo-datalist', [App\Http\Controllers\DataController::class, "emoDatalist"]);
    Route::post('/equipment-trends', [App\Http\Controllers\DataController::class, "equipmentTrends"]);

    Route::get("/summary", [App\Http\Controllers\DataController::class, "summary"]);

    Route::get("/chartjs", function () {
        return view("maintenance.chartjs", [
            "title" => "ChartJS"
        ]);
    });

    Route::get("/dashboards", function () {
        return view("maintenance.dashboards", [
            "title" => "Dashboard"
        ]);
    });

    Route::get("/wiring-render", function () {
        return response()->file("wiring/INVERTER_ACS580.pdf");
    });

    Route::middleware(AdministratorMiddleware::class)->group(function () {
        Route::get("/search-equipment", function () {
            return view("maintenance.search-equipment", [
                'title' => "Search Equipment"
            ]);
        })->name("searchEquipment");
        Route::post("/edit-equipment", [App\Http\Controllers\DataController::class, "editEquipment"]);
        Route::post("/update-equipment", [App\Http\Controllers\DataController::class, "updateEquipment"]);

        Route::post("/equipment", [App\Http\Controllers\DataController::class, "equipment"]);

        Route::get("/install-dismantle", function () {
            return view("maintenance.install-dismantle", [
                "title" => "Install Dismantle",
            ]);
        });

        Route::post("install-dismantle", [App\Http\Controllers\DataController::class, "doInstalDismantle"]);
    });

    Route::get("/chart", function () {
        return view("maintenance.chart", [
            "title" => "Stepped Chart"
        ]);
    });
});
