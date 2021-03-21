<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;

Route::get('/login', [LoginController::class, 'loginForm'])->name('customer.login');
Route::post('/login', [LoginController::class, 'login'])->name('customer.post_login');



// Auth::routes();
//ROUTING INI MENCAKUP SEMUA ROUTING YANG BERKAITAN DENGAN AUTHENTICATION
//JADI INI GROUPING ROUTE, SEHINGGA SEMUA ROUTE YANG ADA DIDALAMNYA
//SECARA OTOMATIS AKAN DIAWALI DENGAN administrator
//CONTOH: /administrator/category ATAU /administrator/product, DAN SEBAGAINYA
Route::group(['prefix' => 'administrator', 'middleware' => 'auth'], function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home'); 
    Route::get('/logout', [LoginController::class, 'logout'])->name('customer.logout');
    Route::resource('category', CategoryController::class)->except(['create', 'show']);
    Route::resource('product', ProductController::class);

});
