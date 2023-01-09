<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\AdminController;



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



Route::get('/', function () {
    return redirect('/dashboard');
});



Route::get('/welcome', function () {
    return view('/welcome');
});





Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';

Route::middleware('auth')->group(function(){
    Route::get('account', [UserController::class, 'account'])->name('account');
    Route::post('account/change', [UserController::class, 'changeName'])->name('change_name');
    Route::get('magazyn', [ProductController::class, 'magazyn'])->name('magazyn');
    Route::get('magazyn/detail/{id}', [ProductController::class, 'productDetail'])->name('productDetail');
    Route::get('search', [ProductController::class, 'searchProducts'])->name('searchProducts');






});



Route::group(['middleware' => ['role:admin']], function(){
    Route::get('admin', [AdminController::class, 'home'])->name('admin');
    Route::get('magazyn/edit/{id}', [ProductController::class, 'productEdit'])->name('productEdit');
    Route::post('magazyn/delete_photos', [ProductController::class, 'deleteMultiplePhotos'])->name('magazyn_delete_photos');
    Route::post('magazyn/delete_photo', [ProductController::class, 'deletePhoto'])->name('magazyn_delete_photo');
    Route::post('magazyn/add_photo', [ProductController::class, 'addPhoto'])->name('magazyn_add_photo');
    Route::post('magazyn/add', [ProductController::class, 'addItem'])->name('magazyn_add_item');
    Route::post('users/search', [UserController::class, 'searchUsers'])->name('search_users');
    Route::get('admin/remove/{user}', [AdminController::class, 'removeAdmin'])->name('remove_admin');
    Route::get('admin/add/{user}', [AdminController::class, 'makeAdmin'])->name('add_admin');
    Route::post('categories/search', [ProductController::class, 'searchCategories'])->name('search_categories');
    Route::post('magazyn/update', [ProductController::class, 'productUpdate'])->name('productUpdate');
    Route::delete('magazyn/{id}', [ProductController::class, 'destroy'])->name('product.destroy');
});



