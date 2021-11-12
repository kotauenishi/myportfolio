<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OrdersController;
use App\Http\Controllers\PsController;

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
    return view('welcome');
});

Route::resource('index', OrdersController::class);

Auth::routes();

Route::get('purchase', [PsController::class,'purchaseView'])->name('purchaseView');
Route::get('shipping', [PsController::class,'shippingView'])->name('shippingView');
Route::get('receive', [PsController::class,'receiveView'])->name('receiveView');
Route::post('purchase', [PsController::class,'purchase'])->name('purchase');
Route::post('shipping', [PsController::class,'shipping'])->name('shipping');
Route::post('receive', [PsController::class,'receive'])->name('receive');

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
