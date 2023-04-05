<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\HomeController;
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
    return view('users.home');
});

Route::group(['prefix' => 'admin'], function () {
    Route::controller(ProductController::class)->group(function () {
        Route::get('/create', 'Create')->name('Product.create');
        Route::post('/create', 'CreatePost');

        Route::get('/edit/{id}', 'Edit')->name('Product.edit');
        Route::post('/edit', 'EditPost')->name('Product.EditPost');

        Route::get('/delete/{id}', 'Delete')->name('Product.Delete');

    });
    Route::controller(CategoryController::class)->group(function () {
        Route::get('/create', 'Create')->name('Category.create');
        Route::post('/create', 'CreatePost');

        Route::get('/edit/{id}', 'Edit')->name('Category.edit');
        Route::post('/edit', 'EditPost')->name('Category.EditPost');

        Route::get('/delete/{id}', 'Delete')->name('Category.Delete');
    });
    Route::controller(UserController::class)->group(function () {
        Route::get('/list', 'list')->name('User.list');

        Route::get('/delete/{id}', 'Delete')->name('User.Delete');
    });
    Route::controller(AdminController::class)->group(function () {
        Route::get('/home', 'Home')->name('Admin.home');

    });

});

Auth::routes();

Route::get('admin/home', [HomeController::class, 'adminHome'])->name('admin.home')->middleware('is_admin');
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
