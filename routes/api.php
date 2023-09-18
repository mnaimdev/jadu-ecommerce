<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\SubcategoryController;
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

Route::middleware('auth:sanctum')->group(function () {
    // login action goes here for customer
});


Route::controller(AuthController::class)->group(function () {

    // admin
    Route::post('/register', 'register');

    Route::get('/logout/{token}', 'logout');

    Route::post('/login', 'login');
    Route::put('/profile', 'profileUpdate');

    Route::post('/forget/password', 'forgetPassword');
});


Route::get('/category', [CategoryController::class, 'categoryList']);
Route::get('/subcategory/{id}', [SubcategoryController::class, 'subcategoryList']);
