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
        Route::get('/list-product', 'List')->name('Product.list');
        Route::get('/create-product', 'Create')->name('Product.create');
        Route::post('/create-product', 'CreatePost')->name('Product.createPost');

        Route::get('/edit-product/{id}', 'Edit')->name('Product.edit');
        Route::post('/edit-product/{id}', 'EditPost')->name('Product.EditPost');

        Route::get('/delete-product/{id}', 'Delete')->name('Product.Delete');

    });
    Route::controller(CategoryController::class)->group(function () {
        Route::get('/list-category', 'List')->name('Category.list');
        Route::get('/create-category', 'Create')->name('Category.create');
        Route::post('/create-category', 'CreatePost')->name('Category.createPost');

        Route::get('/edit-category/{id}', 'Edit')->name('Category.edit');
        Route::post('/edit-category/{id}', 'EditPost')->name('Category.EditPost');

        Route::get('/delete-category/{id}', 'Delete')->name('Category.Delete');
    });
    Route::controller(UserController::class)->group(function () {
        Route::get('/list-user', 'list')->name('User.list');

        Route::get('/delete-user/{id}', 'Delete')->name('User.Delete');
    });
    Route::controller(AdminController::class)->group(function () {
        Route::get('/home', 'Home')->name('Admin.home');

    });

});

Auth::routes();

Route::get('admin/home', [HomeController::class, 'adminHome'])->name('admin.home')->middleware('is_admin');
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
