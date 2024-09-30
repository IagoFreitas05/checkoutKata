<?php

use \App\adapter\Http\Controllers\CheckoutController;
use Illuminate\Support\Facades\Route;

Route::post('/checkout/total', [CheckoutController::class, 'calculateTotal']);
