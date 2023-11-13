<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\BannerController;
use App\Http\Controllers\Api\BrandsController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\FavouriteController;
use App\Http\Controllers\Api\FavouritesController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\ProfileController;
use Database\Factories\FavouriteFactory;

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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
// Route::get('/', function () {
//     return view('welcome');
// });

Route::post('login', [AuthController::class, 'login']);
Route::post('register', [AuthController::class, 'register']);
Route::post('reset-password', [AuthController::class, 'resetPassword']);
Route::post('activate-reset-password/{token}',[AuthController::class, 'activateResetPassword']);

Route::middleware('auth:sanctum')->group(function () {
    
    Route::post('logout', [AuthController::class, 'logout']);

    Route::get('brands', [BrandsController::class, 'index']);
    Route::get('brands/{brand_id}', [BrandsController::class, 'show']);

    Route::get('banners', [BannerController::class, 'index']);

    Route::get('orders', [OrderController::class, 'index']);
    Route::post('orders/create', [OrderController::class, 'create']);
    Route::get('orders/{order_id}', [OrderController::class, 'show']);

    Route::get('categories', [CategoryController::class, 'index']);
    Route::get('categories/{category_id}', [CategoryController::class, 'show']);

    Route::get('products', [ProductController::class, 'index']);
    Route::get('products/{product_id}', [ProductController::class, 'show']);
    Route::get('products/search/{name}', [ProductController::class, 'search']);

    Route::get('favourites', [FavouriteController::class, 'index']);
    Route::post('favourites/create/{id}', [FavouriteController::class, 'create']);
    Route::delete('favourites/delete/{id}', [FavouriteController::class, 'destroy']);

    Route::get('fetch-profile', [ProfileController::class, 'fetchProfile']);
    Route::post('edit-profile', [ProfileController::class, 'updateProfile']);
    Route::post('change-password', [ProfileController::class, 'changePassword']);
}); 