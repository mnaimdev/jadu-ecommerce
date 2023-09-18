<?php

use App\Http\Controllers\BannerController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SubcategoryController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('auth.login');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


// category
Route::controller(CategoryController::class)->group(function () {
    Route::get('/category', 'category')->name('category');
    Route::post('/category/store', 'categoryStore')->name('category.store');
    Route::get('/category/edit/{id}', 'categoryEdit')->name('category.edit');
    Route::post('/category/update', 'categoryUpdate')->name('category.update');
    Route::get('/category/delete/{id}', 'categoryDelete')->name('category.delete');
});

// subcategory
Route::controller(SubcategoryController::class)->group(function () {
    Route::get('/subcategory', 'subcategory')->name('subcategory');

    Route::post('/subcategory/store', 'subcategoryStore')->name('subcategory.store');
    Route::get('/subcategory/edit/{id}', 'subcategoryEdit')->name('subcategory.edit');
    Route::post('/subcategory/update', 'subcategoryUpdate')->name('subcategory.update');
    Route::get('/subcategory/delete/{id}', 'subCategoryDelete')->name('subcategory.delete');
});


// banner
Route::controller(BannerController::class)->group(function () {
    Route::get('/baner', 'banner')->name('banner');

    Route::post('/banner/store', 'bannerStore')->name('banner.store');
    Route::get('/banner/edit/{id}', 'bannerEdit')->name('banner.edit');
    Route::post('/banner/update', 'bannerUpdate')->name('banner.update');
    Route::get('/banner/delete/{id}', 'bannerDelete')->name('banner.delete');
});


require __DIR__ . '/auth.php';
