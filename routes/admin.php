<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\BannerController;
use App\Http\Controllers\Admin\AccountController;
use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\BusinessController;
use App\Http\Controllers\Admin\CategoryCntroller;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\SKUController;
use App\Http\Controllers\Admin\Target\TargetController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::group(['middleware' => 'admin_auth'], function()
{
    Route::get('dashboard', [DashboardController::class, 'dashboard'])->name('admin.dashboard');

    Route::get('logout', [AuthController::class, 'logout'])->name('logout');

    Route::get('/', [CategoryController::class, 'index'])->name('admin.category.index');

    Route::controller(AdminController::class)->group(function () {
        Route::group(["prefix" => "admin"], function ()
        {
            Route::get('/index', 'index')->name('admin.users.admins');
            Route::post('create', 'createAdmin')->name('admin.admins.create');
            Route::put('edit/{user_id}', 'updateAdmin')->name('admin.admins.edit');
            Route::delete('delete-admin/{user_id}', 'deleteAdmin')->name('admin.admins.delete');
        });
    });

    Route::controller(CustomerController::class)->group(function () {

        Route::group(["prefix" => "customer"], function ()
        {
            Route::get('/index', 'index')->name('admin.users.customer');
            Route::post('create', 'createCustomer')->name('admin.customer.create');
            Route::put('edit/{customer_id}', 'updateCustomer')->name('admin.customer.edit');
            Route::delete('delete-admin/{customer_id}', 'deleteAdmin')->name('admin.customer.delete');
        });
    });

    Route::controller(BannerController::class)->group(function () {
        Route::group(["prefix" => "banners"], function ()
        {
            Route::get('/', 'index')->name('admin.banner.index');
            Route::match(['GET', 'POST'], 'create-banner', 'createBanner')->name('admin.banner.create');
            Route::match(['GET', 'PATCH'], 'edit-banner/{banner_id}', 'editBanner')->name('admin.banner.edit');
            Route::delete('delete-banner/{banner_id}', 'deleteBanner')->name('admin.banner.delete');
            Route::get('remove-banner-image/{banner_id}/{image_id}', 'removeImage')->name('admin.banner.remove.image');
        });
    });

    Route::controller(BrandController::class)->group(function () {
        Route::group(["prefix" => "brands"], function ()
        {
            Route::get('/', 'index')->name('admin.brand.index');
            Route::match(['GET', 'POST'], 'create-brand', 'createBrand')->name('admin.brand.create');
            Route::match(['GET', 'PATCH'], 'edit-brand/{brand_id}', 'editBrand')->name('admin.brand.edit');
            Route::delete('delete-brand/{brand_id}', 'deleteBrand')->name('admin.brand.delete');
            Route::get('remove-brand-image/{brand_id}/{image_id}', 'removeImage')->name('admin.brand.remove.image');
        });
    });

    Route::controller(CategoryController::class)->group(function () {
        Route::group(["prefix" => "categories"], function ()
        {
            Route::get('/', 'index')->name('admin.category.index');
            Route::match(['GET', 'POST'], 'create-category', 'createCategory')->name('admin.category.create');
            Route::match(['GET', 'PATCH'], 'edit-category/{category_id}', 'editCategory')->name('admin.category.edit');
            Route::delete('delete-category/{category_id}', 'deleteCategory')->name('admin.category.delete');
            Route::get('remove-category-image/{category_id}/{image_id}', 'removeImage')->name('admin.category.remove.image');
        });
    });

    Route::controller(SKUController::class)->group(function () {
        Route::group(["prefix" => "categories"], function ()
        {
            Route::get('/', 'index')->name('admin.sku.index');
            Route::match(['GET', 'POST'], 'create-sku', 'createSku')->name('admin.sku.create');
            Route::match(['GET', 'PATCH'], 'edit-sku/{product_id}', 'editSku')->name('admin.sku.edit');

        });
    });


});

