<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AccountController;
use App\Http\Controllers\Admin\BusinessController;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\DashboardController;
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

});

