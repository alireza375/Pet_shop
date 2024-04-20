<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\ContactController;
use App\Http\Controllers\Admin\NewsletterController;
use App\Http\Controllers\Admin\PageController;
use App\Http\Controllers\Admin\SettingController;
use Illuminate\Routing\Route as RoutingRoute;

Route::group(['middleware' => 'admin'], function () {

    Route::get('contact',[ContactController::class, 'GetContact']);
    Route::post('contact/delete',[ContactController::class, 'delete']);
    Route::get('contact/show{id?}', [ContactController::class, 'show']);
    Route::post('contact/reply', [ContactController::class, 'ContactReply']);

    Route::get('page/list', [PageController::class, 'index']);
    Route::get('get/page', [PageController::class, 'getPage']);
    Route::post('page', [PageController::class, 'updateOrcreate']);
    Route::post('delete/page', [PageController::class, 'deletePage']);


    Route::post('setting', [SettingController::class, 'Settings']);
    Route::get('get/setting', [SettingController::class, 'GetSetting']);

    Route::get('newsletter/list', [NewsletterController::class, 'ListNews']);
    Route::post('delete/newsletter', [NewsletterController::class, 'DelNewsletter']);



});
