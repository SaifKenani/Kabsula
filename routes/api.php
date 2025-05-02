<?php

use App\Http\Controllers\AuthController;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


//Public Routes
Route::prefix('v1')->post('/register', [AuthController::class, 'register']);
Route::prefix('v1')->post('/login', [AuthController::class, 'login']);


Route::prefix('v1')->middleware(['auth:sanctum','is_customer'])->get('post',function(){

   /*$admin= \App\Models\Admin::create([
       'role' => 'admin',
   ]);
   $admin->user()->create([
       'name' => 'admin',
       'email'=>'sa@s.com',
       'password'=> bcrypt('123456'),
   ]);*/

//    return auth()->user()->userable;



});
