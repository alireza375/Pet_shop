<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Auth\VarifyController;
use App\Http\Controllers\Auth\ProfileController;
use App\Http\Controllers\Admin\ContactController;
use App\Http\Controllers\Admin\NewsletterController;

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


Route::post('user/registration', [AuthController::class, 'registration']);
Route::post('user/login', [AuthController::class, 'login']);
Route::post('reset/password', [AuthController::class, 'ResetPassword']);


Route::post('Sent-otp', [VarifyController::class, 'SentOtp']);
Route::post('verify-otp', [VarifyController::class, 'VerifyOtp']);

Route::post('user/contact', [ContactController::class, 'Store']);

Route::post('newsletter', [NewsletterController::class, 'newsletter']);


Route::group(['middleware' => 'checkUser'],function () {

    Route::post('update/password', [AuthController::class, 'UpdatePassword']);

    Route::get('get/profile', [ProfileController::class, 'GetProfile']);
    Route::post('update/profile', [ProfileController::class, 'UpdateProfile']);


    // Route::get('user/details', [UserController::class, 'addOrUpdate']);
    // Route::get('user/details{id?}', [UserController::class, 'show']);


});
