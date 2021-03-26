<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Ecommerce\LoginController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\Ecommerce\FrontController;
use App\Http\Controllers\Ecommerce\CartController;
use App\Imports\ProductImport;
use App\Http\Controllers\Ecommerce\OrderController;
use App\Http\Controllers\OrderController as OrderController2;

Route::get('/', [FrontController::class, 'index'])->name('front.index');
Route::get('/product', [FrontController::class, 'product'])->name('front.product');
Route::get('/category/{slug}', [FrontController::class, 'categoryProduct'])->name('front.category');
Route::get('/product/{slug}', [FrontController::class, 'show'])->name('front.show_product');
Route::post('/cart', [CartController::class, 'addToCart'])->name('front.cart');
Route::get('/cart', [CartController::class, 'listCart'])->name('front.list_cart');
Route::post('/cart/update', [CartController::class, 'updateCart'])->name('front.update_cart');
Route::get('/checkout', [CartController::class, 'checkout'])->name('front.checkout');
Route::post('/checkout', [CartController::class, 'processCheckout'])->name('front.store_checkout');
Route::get('/checkout/{invoice}', [CartController::class, 'checkoutFinish'])->name('front.finish_checkout');

Auth::routes();

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

    Route::group(['prefix' => 'reports'], function () {
        Route::get('/order', [HomeController::class, 'orderReport'])->name('report.order');
        Route::get('/order/pdf/{daterange}', [HomeController::class, 'orderReportPdf'])->name('report.order_pdf');
        Route::get('/return', [HomeController::class, 'returnReport'])->name('report.return');
        Route::get('/return/pdf/{daterange}', [HomeController::class, 'returnReportPdf'])->name('report.return_pdf');
    });

    Route::group(['prefix' => 'orders'], function () {
        Route::get('/', [OrderController2::class, 'index'])->name('orders.index');
        Route::delete('/{id}', [OrderController2::class, 'destroy'])->name('orders.destroy');
        Route::get('/{invoice}', [OrderController2::class, 'view'])->name('orders.view');
        Route::get('/payment/{invoice}', [OrderController2::class, 'acceptPayment'])->name('orders.approve_payment');
        Route::post('/shipping', [OrderController2::class, 'shippingOrder'])->name('orders.shipping');
        Route::get('/return/{invoice}', [OrderController2::class, 'return'])->name('orders.return');
        Route::post('/return', [OrderController2::class, 'approveReturn'])->name('orders.approve_return');
    });
});

Route::group(['prefix' => 'member', 'namespace' => 'Ecommerce'], function () {
    Route::get('/login', [LoginController::class, 'loginForm'])->name('customer.login');
    Route::post('/login', [LoginController::class, 'login'])->name('customer.post_login');
    Route::get('/verify/{token}', [FrontController::class, 'verifyCustomerRegistration'])->name('customer.verify');

    Route::group(['middleware' => 'customer'], function () {
        Route::get('/dashboard', [LoginController::class, 'dashboard'])->name('customer.dashboard');
        Route::get('/logout', [LoginController::class, 'logout'])->name('customer.logout');
        Route::get('/orders', [OrderController::class, 'index'])->name('customer.orders');
        Route::get('/orders/{invoice}', [OrderController::class, 'view'])->name('customer.view_order');
        Route::get('/payment', [OrderController::class, 'paymentForm'])->name('customer.paymentForm');
        Route::post('/payment', [OrderController::class, 'storePayment'])->name('customer.savePayment');
        Route::get('/setting', [FrontController::class, 'customerSettingForm'])->name('customer.settingForm');
        Route::post('/setting', [FrontController::class, 'customerUpdateProfile'])->name('customer.setting');
        Route::get('/orders/pdf/{invoice}', [OrderController::class, 'pdf'])->name('customer.order_pdf');
        Route::post('orders/accept', [OrderController::class, 'acceptOrder'])->name('customer.order_accept');
        Route::get('/return/{invoice}', [OrderController::class, 'returnForm'])->name('customer.order_return');
        Route::put('/return/{invoice}', [OrderController::class, 'processReturn'])->name('customer.return');
    });
});




Route::get('/test', function () {
    $filename = '1616393491-product.xlsx';
    file_put_contents(storage_path('app/public/products') . '/' . $filename, file_get_contents($row[4]));
    $files = (new ProductImport)->toArray(storage_path('app/public/uploads/' . $this->filename));
});
