<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Ecommerce\CartController;


Route::get('city', [CartController::class, 'getCity']);
Route::get('district', [CartController::class, 'getDistrict']);
