<?php

use App\Http\Controllers\AuthController;
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
Route::prefix('v1')->middleware(['auth:sanctum', 'is_customer'])->group(function () {

    Route::get('/post', function () {
        return response()->json([
            'message' => 'مرحباً، تم التحقق من المستخدم.'
        ]);
    });

    // أضف هنا المزيد من المسارات المحمية حسب الحاجة
});
