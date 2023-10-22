<?php

use App\Http\Controllers\Controller;
use App\Http\Middleware\OnlyGuestMiddleware;
use App\Http\Middleware\OnlyMemberMiddleware;
use Illuminate\Http\Request as HttpRequest;
use Illuminate\Support\Facades\Http;
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

    Route::get('/checking-form/{motorList}', [App\Http\Controllers\DataController::class, "getForm"]);
    Route::post('/checking-form/{motorList}', [App\Http\Controllers\DataController::class, "saveData"]);

    Route::get('/change-name', [App\Http\Controllers\UserController::class, "changeName"]);
    Route::post('/change-name', [App\Http\Controllers\UserController::class, "doChangeName"]);

    Route::get('/change-password', [App\Http\Controllers\UserController::class, "changePassword"]);
    Route::post('/change-password', [App\Http\Controllers\UserController::class, "doChangePassword"]);

    Route::get('/show-data', function () {
        return view("maintenance.show-data", [
            "title" => "Data"
        ]);
    });

    Route::get('/trends/{emo}', [App\Http\Controllers\DataController::class, "trends"]);
});
