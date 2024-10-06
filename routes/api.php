<?php

use App\Http\Controllers\Api\CartController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

Route::post('register', [UserController::class, 'register'])->name('register');
Route::post('login', [UserController::class, 'login'])->name('login');


Route::group(['middleware' => ["auth:sanctum"]], function () {
    Route::get('profile', [UserController::class, 'profile'])->name('profile');
    Route::post('logout', [UserController::class, 'logout'])->name('logout');
    Route::post('category', [CategoryController::class, 'create'])->name('category');
    Route::get('category', [CategoryController::class, 'getcategory'])->name('getcategory');
    Route::post('product', [ProductController::class, 'createproduct'])->name('product');
    Route::get('product', [ProductController::class, 'getproduct'])->name('getproduct');
    Route::post('cart', [CartController::class, 'createCart'])->name('createCart');
    Route::get('getcart', [CartController::class, 'getCart'])->name('getCart');
    Route::put('update/{cartid}/{scope}', [CartController::class, 'updateCart'])->name('updateCart');
    Route::delete('deletecart/{deleteid}', [CartController::class, 'deleteCart'])->name('deleteCart');
    Route::get('singleproduct/{singleproduct}', [ProductController::class, 'singleProduct'])->name('singleproduct');
});
Route::post('products', [ProductController::class, 'getproduct'])->name('getproduct');
