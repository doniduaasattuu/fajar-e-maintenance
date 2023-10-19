<?php

use App\Http\Middleware\OnlyGuestMiddleware;
use App\Http\Middleware\OnlyMemberMiddleware;
use Illuminate\Http\Request as HttpRequest;
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
        return view("utility.page-not-found", [
            "title" => "Oops!"
        ]);
    });

    Route::get('/scanner', function () {
        return view("maintenance.scanner", [
            "title" => "Scanner"
        ]);
    });

    Route::get('/', function (HttpRequest $request) {
        return view("maintenance.home", [
            "title" => "Home",
            "user" => $request->session()->get("user")
        ]);
    });

    Route::get("/logout", function (HttpRequest $request) {
        $request->session()->flush();
        return redirect("/");
    });

    Route::get('/checking-form/{motorList}', [App\Http\Controllers\DataController::class, "getForm"]);
    Route::post('/checking-form/{motorList}', [App\Http\Controllers\DataController::class, "saveData"]);
});
