<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\SKUController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\BannerController;
use App\Http\Controllers\Admin\AccountController;
use App\Http\Controllers\Admin\CategoryCntroller;
use App\Http\Controllers\Admin\BusinessController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\Target\TargetController;
use App\Http\Controllers\Admin\PermissionController;

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

    Route::get('/categories', [CategoryController::class, 'index'])->name('admin.category.index');

    Route::controller(AdminController::class)->group(function () {
        Route::group(["prefix" => "admin"], function ()
        {
            Route::get('/index', 'index')->name('admin.users.admins');
            Route::post('create-admin', 'createAdmin')->name('admin.admins.create');
            Route::put('edit-admin/{user_id}', 'updateAdmin')->name('admin.admins.edit');
            Route::delete('delete-admin/{user_id}', 'deleteAdmin')->name('admin.admins.delete');
        });
    });

    Route::controller(CustomerController::class)->group(function () {

        Route::group(["prefix" => "customer"], function ()
        {
            Route::get('/index', 'index')->name('admin.customer.index');
            Route::match(['GET', 'POST'], 'create-customer', 'createCustomer')->name('admin.customer.create');
            Route::post('import-customer', 'importCustomer')->name('admin.customer.import');
            Route::post('import-customer-account', 'importCustomerAccount')->name('admin.customer.account.import');
            Route::put('import-customer-account/{account_id}', 'updateCustomerAccount')->name('admin.customer.account.edit');
            Route::get('export-customer', 'exportCustomer')->name('admin.customer.export');
            Route::get('export-customer-account', 'exportCustomerAccount')->name('admin.customer.account.export');
            Route::match(['GET', 'POST'], 'create-customer-deposit', 'createCustomerDeposit')->name('admin.customer.deposit.create');
            Route::put('edit/{customer_id}', 'updateCustomer')->name('admin.customer.edit');
            Route::get('account-statement', 'accountStatement')->name('admin.customer.acount.index');
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
        Route::group(["prefix" => "skus"], function ()
        {
            Route::get('/', 'index')->name('admin.sku.index');
            Route::match(['GET', 'POST'], 'create-sku', 'createSku')->name('admin.sku.create');
            Route::get('export-sku', 'exportSku')->name('admin.sku.export');
            Route::put('edit-sku/{product_id}', 'editSku')->name('admin.sku.edit');

        });
    });

    Route::controller(OrderController::class)->group(function () {
        Route::group(["prefix" => "orders"], function ()
        {
            Route::get('/', 'index')->name('admin.order.index');
            Route::match(['GET', 'POST'], 'create-order', 'createorder')->name('admin.order.create');
            Route::get('show-order/{order_id}', 'showOrder')->name('admin.order.show');
            Route::post('approve-order/{id}', 'approveOrder')->name('admin.order.approve');
        });
    });

    Route::controller(PermissionController::class)->group(function () {
        Route::group(["prefix" => "permissions"], function ()
        {
            Route::get('/', 'index')->name('admin.permissions.index');
            Route::post('create', 'createPermission')->name('admin.permissions.create');
            Route::put('edit/{permission_id}', 'updatePermission')->name('admin.permissions.edit');
            // Route::put('delete-permission', 'deletePermission')->name('admin.permissions.delete');
        });
    });
    
    Route::controller(RoleController::class)->group(function () {
        Route::group(["prefix" => "roles"], function ()
        {
            Route::get('/', 'index')->name('admin.roles.index');
            Route::post('create', 'createRole')->name('admin.roles.create');
            Route::put('edit/{role_id}', 'updateRole')->name('admin.roles.edit');
            // Route::put('delete-role', 'deleteRole')->name('admin.roles.delete');
        });
    });



});

