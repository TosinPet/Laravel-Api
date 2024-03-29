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
use App\Http\Controllers\Admin\PromotionController;
use App\Http\Controllers\Admin\PurchaseController as AdminPurchaseController;
use App\Http\Controllers\PurchaseController;

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
            Route::get('show-customer/{customer_id}', 'showCustomer')->name('admin.customer.show');
        });
    });

    Route::controller(PromotionController::class)->group(function () {
        Route::group(["prefix" => "promotions"], function ()
        {
            Route::get('/', 'index')->name('admin.promotion.index');
            Route::match(['GET', 'POST'], 'create-promotion', 'createPromotion')->name('admin.promotion.create');
            Route::match(['GET', 'PATCH'], 'edit-promotion/{promotion_id}', 'editPromotion')->name('admin.promotion.edit');
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
            Route::match(['GET', 'POST'], 'create-order', 'createOrder')->name('admin.order.create');
            Route::get('show-order/{order_id}', 'showOrder')->name('admin.order.show');
            Route::get('export-order', 'exportOrder')->name('admin.order.export');
            Route::match(['GET', 'PATCH'], 'edit/{order_id}', 'editOrder')->name('admin.order.edit');
            Route::put('/edit-status/{order_id}', 'editStatus')->name('admin.order.editStatus');
            Route::put('/update-status/{order_id}', 'updateStatus')->name('admin.order.update');
        });
    });

    Route::controller(AdminPurchaseController::class)->group(function () {
        Route::group(["prefix" => "purchases"], function ()
        {
            Route::get('/', 'index')->name('admin.purchase.index');
            Route::match(['GET', 'POST'], 'create-purchase', 'createPurchase')->name('admin.purchase.create');
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

