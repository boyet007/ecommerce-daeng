<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Imports\ProductImport;

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
    Route::resource('product', ProductController::class)->except(['show']);
    Route::get('/product/bulk', [ProductController::class, 'massUploadForm'])->name('product.bulk');
    Route::post('/product/bulk', [ProductController::class, 'massUpload'])->name('product.saveBulk');


});


Route::get('/test', function(){
    $filename = '1616393491-product.xlsx';
    file_put_contents(storage_path('app/public/products') . '/' . $filename, file_get_contents($row[4]));
    $files = (new ProductImport)->toArray(storage_path('app/public/uploads/' . $this->filename));
});
