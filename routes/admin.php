<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\FaqController;
use Illuminate\Routing\Route as RoutingRoute;
use App\Http\Controllers\Admin\PageController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\BreedController;
use App\Http\Controllers\Admin\ReviewController;
use App\Http\Controllers\Admin\ContactController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\NewsletterController;
use App\Http\Controllers\Admin\ServiceCateController;
use App\Http\Controllers\Admin\TrainerController;

Route::group(['middleware' => 'admin'], function () {

    Route::post('add/trainer', [TrainerController::class, 'AddTrainer']);
    Route::post('delete/trainer', [TrainerController::class, 'delete']);

    Route::get('contact',[ContactController::class, 'GetContact']);
    Route::post('contact/delete',[ContactController::class, 'delete']);
    Route::get('contact/show{id?}', [ContactController::class, 'show']);
    Route::post('contact/reply', [ContactController::class, 'ContactReply']);

    Route::get('page/list', [PageController::class, 'index']);
    Route::get('get/page', [PageController::class, 'getPage']);
    Route::post('page', [PageController::class, 'updateOrcreate']);
    Route::post('delete/page', [PageController::class, 'deletePage']);

    Route::get('user/list', [UserController::class, 'index']);
    Route::get('user/details{id?}', [UserController::class, 'show']);


    Route::post('setting', [SettingController::class, 'Settings']);
    Route::get('get/setting', [SettingController::class, 'GetSetting']);

    Route::get('newsletter/list', [NewsletterController::class, 'ListNews']);
    Route::post('delete/newsletter', [NewsletterController::class, 'DelNewsletter']);

    Route::get('faq/list', [FaqController::class, 'FaqList']);
    Route::post('faq', [FaqController::class, 'Faq']);
    Route::post('delete/faq', [FaqController::class, 'Delete']);

    Route::get('service/list', [ServiceController::class, 'index']);
    Route::get('service/{id?}', [ServiceController::class, 'show']);
    Route::post('service', [ServiceController::class, 'AddorUpdate']);
    Route::post('service/delete', [ServiceController::class, 'delete']);

    Route::post('service/category', [ServiceCateController::class, 'addOrUpdate']);
    Route::get('service/category/list', [ServiceCateController::class, 'CateList']);
    Route::post('service/category/delete', [ServiceCateController::class, 'Delete']);


    Route::post('brand', [BrandController::class, 'addOrUpdate']);
    Route::get('brand/list', [BrandController::class, 'BrandList']);
    Route::post('brand/delete', [BrandController::class, 'Delete']);


    //product
    Route::get('get/product', [ProductController::class, 'getproduct']);
    Route::get('product/list', [ProductController::class, 'index']);
    Route::post('product', [ProductController::class, 'updateOrAddproduct']);
    Route::delete('product', [ProductController::class, 'delete']);

    Route::post('review/delete', [ReviewController::class, 'delete']);

    Route::post('breed', [BreedController::class, 'addOrUpdate']);
    Route::get('breed/list', [BreedController::class, 'index']);
    Route::post('breed/delete', [BreedController::class, 'Delete']);


});
