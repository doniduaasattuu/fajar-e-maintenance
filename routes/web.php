<?php

use App\Http\Controllers\DocumentController;
use App\Http\Controllers\FindingController;
use App\Http\Controllers\FunclocController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MotorController;
use App\Http\Controllers\PdfController;
use App\Http\Controllers\RecordController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\TrafoController;
use App\Http\Controllers\TrendController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

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

    // DOCUMENTS
    Route::get('/documents', [DocumentController::class, 'documents']);
    Route::get('/documents/{attachment}', [DocumentController::class, 'renderDocument']);
    Route::get('/document-edit/{id}', [DocumentController::class, 'documentEdit']);
    Route::post('/document-update', [DocumentController::class, 'documentUpdate']);
    Route::get('/document-registration', [DocumentController::class, 'documentRegistration']);
    Route::post('/document-register', [DocumentController::class, 'documentRegister']);

    Route::get('/', [HomeController::class, 'home'])->name('home');
    Route::get('/profile', [UserController::class, 'profile'])->name('profile');
    Route::post('/update-profile', [UserController::class, 'updateProfile'])->name('update-profile');
    Route::get('/logout', [UserController::class, 'logout'])->name('logout');

    // TABLES
    Route::get('/funclocs', [FunclocController::class, 'funclocs'])->name('funclocs');
    Route::get('/motors', [MotorController::class, 'motors'])->name('motors');
    Route::get('/trafos', [TrafoController::class, 'trafos'])->name('trafos');
    Route::get('/motor-details/{id}', [MotorController::class, 'motorDetails'])->name('motor-details');
    Route::get('/trafo-details/{id}', [TrafoController::class, 'trafoDetails'])->name('trafo-details');

    // FINDINGS
    Route::get('/findings', [FindingController::class, 'findings'])->name('findings');
    Route::get('/finding-registration', [FindingController::class, 'findingRegistration']);
    Route::post('/finding-register', [FindingController::class, 'findingRegister']);
    Route::get('/finding-edit/{id}', [FindingController::class, 'findingEdit']);
    Route::post('/finding-update', [FindingController::class, 'findingUpdate']);
    Route::get('/finding-delete/{id}', [FindingController::class, 'findingDelete']);

    // CHECKING FORM
    Route::get('/scanner', [HomeController::class, 'scanner'])->name('scanner');
    // MOTOR & TRAFO
    Route::get('/checking-form/{equipment_id}', [RecordController::class, 'checkingForm']);
    // MOTOR
    Route::post('/record-motor', [RecordController::class, 'saveRecordMotor']);
    Route::get('/record-edit/motor/{uniqid}', [RecordController::class, 'editRecordMotor']);
    // TRAFO
    Route::post('/record-trafo', [RecordController::class, 'saveRecordTrafo']);
    Route::get('/record-edit/trafo/{uniqid}', [RecordController::class, 'editRecordTrafo']);

    // TREND
    Route::get('/trends', [TrendController::class, 'trends']);
    Route::post('/trends', [TrendController::class, 'getTrends']);
    Route::get('/equipment-trend/{equipment}', [TrendController::class, 'equipmentTrend'])->name('equipmentTrend');

    // DAILY REPORT
    Route::get('/report', [PdfController::class, 'report']);
    Route::post('/report', [PdfController::class, 'generateReport']);
    Route::get('/report/trafo', [PdfController::class, 'reportTrafoHtml']);
    Route::get('/report/motor', [PdfController::class, 'reportMotorHtml']);
    // Route::get('/report/motor/pdf', [PdfController::class, 'renderPdfMotor']);

    // EQUIPMENT REPORT
    Route::get('/report/motor/{equipment}/{start_date}/{end_date}', [PdfController::class, 'reportMotorEquipment']);
    // Route::post('/report/motor', [PdfController::class, 'reportMotorEquipment']);
    Route::get('/report/trafo/{equipment}', [PdfController::class, 'reportTrafoEquipment']);

    Route::middleware('role:db_admin')->group(function () {
        // DOCUMENT
        Route::get('/document-delete/{id}', [DocumentController::class, 'documentDelete']);

        // FUNCLOC
        Route::get('/funcloc-edit/{id}', [FunclocController::class, 'funclocEdit'])->name('funcloc-edit');
        Route::post('/funcloc-update', [FunclocController::class, 'funclocUpdate'])->name('funcloc-update');
        Route::get('/funcloc-registration', [FunclocController::class, 'funclocRegistration'])->name('funcloc-registration');
        Route::post('/funcloc-register', [FunclocController::class, 'funclocRegister'])->name('funcloc-register');
        Route::post('/funcloc-status', [FunclocController::class, 'funclocStatus']);

        // MOTOR
        Route::get('/motor-edit/{id}', [MotorController::class, 'motorEdit'])->name('motor-edit');
        Route::post('/motor-update', [MotorController::class, 'motorUpdate'])->name('motor-update');
        Route::get('/motor-registration', [MotorController::class, 'motorRegistration'])->name('motor-registration');
        Route::post('/motor-register', [MotorController::class, 'motorRegister'])->name('motor-register');
        // MOTOR INSTALL - DISMANTLE
        Route::post('/equipment-motor', [MotorController::class, 'equipmentMotor']);
        Route::get('/motor-install-dismantle', [MotorController::class, 'motorInstallDismantle']);
        Route::post('/motor-install-dismantle', [MotorController::class, 'doMotorInstallDismantle']);

        // TRAFO
        Route::get('/trafo-edit/{id}', [TrafoController::class, 'trafoEdit'])->name('trafo-edit');
        Route::post('/trafo-update', [TrafoController::class, 'trafoUpdate'])->name('trafo-update');
        Route::get('/trafo-registration', [TrafoController::class, 'trafoRegistration'])->name('trafo-registration');
        Route::post('/trafo-register', [TrafoController::class, 'trafoRegister'])->name('trafo-register');
        // TRAFO INSTALL - DISMANTLE
        Route::post('/equipment-trafo', [TrafoController::class, 'equipmentTrafo']);
        Route::get('/trafo-install-dismantle', [TrafoController::class, 'trafoInstallDismantle']);
        Route::post('/trafo-install-dismantle', [TrafoController::class, 'doTrafoInstallDismantle']);
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
