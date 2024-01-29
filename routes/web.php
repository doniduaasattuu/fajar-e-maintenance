<?php

use App\Http\Controllers\FunclocController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MotorController;
use App\Http\Controllers\RecordController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\TrendController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\OnlyGuestMiddleware;
use App\Http\Middleware\OnlyMemberMiddleware;
use App\Http\Middleware\RoleMiddleware;
use App\Models\Motor;
use App\Models\Role;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the 'web' middleware group. Make something great!
|
*/

Route::middleware('guest')->group(function () {
    Route::get('/login', [App\Http\Controllers\UserController::class, 'login'])->name('login');
    Route::post('/login', [App\Http\Controllers\UserController::class, 'doLogin']);
    Route::get('/registration', [App\Http\Controllers\UserController::class, 'registration'])->name('registration');
    Route::post('/registration', [App\Http\Controllers\UserController::class, 'register']);
});

Route::middleware('member')->group(function () {
    // SEARCH 
    Route::post('/search', [HomeController::class, 'search'])->name('search');

    Route::get('/', [HomeController::class, 'home'])->name('home');
    Route::get('/profile', [UserController::class, 'profile'])->name('profile');
    Route::post('/update-profile', [UserController::class, 'updateProfile'])->name('update-profile');
    Route::get('/logout', [UserController::class, 'logout'])->name('logout');

    // TABLES
    Route::get('/funclocs', [FunclocController::class, 'funclocs'])->name('funclocs');
    Route::get('/motors', [MotorController::class, 'motors'])->name('motors');
    Route::get('/motor-details/{id}', [MotorController::class, 'motorDetails'])->name('motor-details');

    // CHECKING FORM
    Route::get('/scanner', [HomeController::class, 'scanner'])->name('scanner');

    Route::get('/checking-form/{equipment_id}', [RecordController::class, 'checkingForm']);
    Route::post('/record-motor', [RecordController::class, 'saveRecordMotor']);
    Route::get('/record-edit/{uniqid}', [RecordController::class, 'editRecordMotor']);
    Route::get('/checking-form', [HomeController::class, 'checkingForm']);

    // TREND
    Route::get('/equipment-trend/{equipment}', [TrendController::class, 'equipmentTrend'])->name('equipmentTrend');

    Route::middleware('role:db_admin')->group(function () {
        Route::get('/funcloc-edit/{id}', [FunclocController::class, 'funclocEdit'])->name('funcloc-edit');
        Route::post('/funcloc-update', [FunclocController::class, 'funclocUpdate'])->name('funcloc-update');
        Route::get('/funcloc-registration', [FunclocController::class, 'funclocRegistration'])->name('funcloc-registration');
        Route::post('/funcloc-register', [FunclocController::class, 'funclocRegister'])->name('funcloc-register');
        Route::post('/funcloc-status', [FunclocController::class, 'funclocStatus']);

        Route::get('/motor-edit/{id}', [MotorController::class, 'motorEdit'])->name('motor-edit');
        Route::post('/motor-update', [MotorController::class, 'motorUpdate'])->name('motor-update');
        Route::get('/motor-registration', [MotorController::class, 'motorRegistration'])->name('motor-registration');
        Route::post('/motor-register', [MotorController::class, 'motorRegister'])->name('motor-register');
        // INSTALL - DISMANTLE
        Route::post('/equipment-motor', [MotorController::class, 'equipmentMotor']);
        Route::get('/motor-install-dismantle', [MotorController::class, 'motorInstallDismantle']);
        Route::post('/motor-install-dismantle', [MotorController::class, 'doMotorInstallDismantle']);
    });

    Route::middleware('role:admin')->group(function () {
        Route::get('/users', [UserController::class, 'users']);
        Route::get('/user-delete/{nik}', [UserController::class, 'userDelete']);
        Route::get('/user-reset/{nik}', [UserController::class, 'userReset']);

        Route::get('/role-delete/db_admin/{nik}', [RoleController::class, 'roleDeleteDbAdmin']);
        Route::get('/role-assign/db_admin/{nik}', [RoleController::class, 'roleAssignDbAdmin']);
        Route::get('/role-delete/admin/{nik}', [RoleController::class, 'roleDeleteAdmin']);
        Route::get('/role-assign/admin/{nik}', [RoleController::class, 'roleAssignAdmin']);
    });
});
