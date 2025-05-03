<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\FormController;
use App\Http\Controllers\ManufacturerController;
use App\Http\Controllers\VerifyAccountController; // تأكد من استيراد الكنترولر الصحيح
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// 🔓 Public Routes
Route::prefix('v1')->group(function () {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/send-code/email', [VerifyAccountController::class, 'sendCodeToEmail']);
    Route::get('hi',function(){
        return view('emails.verify-code');
    });
});

// 🔒 Protected Routes (للعملاء المسجلين فقط)
Route::prefix('v1')->middleware(['auth:sanctum'])->group(function () {
    // for form
    Route::prefix('forms')->group(function () {
        Route::get('/', [FormController::class, 'index']);
        Route::get('/{id}', [FormController::class, 'show']);
        Route::post('/', [FormController::class, 'store']);
        Route::put('/{id}', [FormController::class, 'update']);
        Route::delete('/{id}', [FormController::class, 'destroy']);

    });

    // for manufacturer
    Route::prefix('manufacturers')->group(function () {
        Route::get('/', [ManufacturerController::class, 'index']);
        Route::get('/{id}', [ManufacturerController::class, 'show']);
        Route::post('/', [ManufacturerController::class, 'store']);
        Route::put('/{id}', [ManufacturerController::class, 'update']);
        Route::delete('/{id}', [ManufacturerController::class, 'destroy']);

    });



});
