<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/verifyEmailSuccess', function () {
    return view('emailSuccess');
});

//Route Resource
// Route::resource('/supplier', 
// \App\Http\Controllers\SupplierController::class);
// Route::resource('/barang', 
// \App\Http\Controllers\BarangController::class);
// Route::resource('/user', 
// \App\Http\Controllers\UserController::class);
