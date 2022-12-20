<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\SupplierController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\BarangController;
use App\Http\Controllers\VerifyEmailController;
use App\Http\Controllers\Api\KeranjangController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Verify email
Route::get('/email/verify/{id}/{hash}', [VerifyEmailController::class, '__invoke'])
    ->name('verification.verify');

 

// Resend link to verify email
Route::post('/email/verify/resend', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();
    return back()->with('message', 'Verification link sent!');
});

// Route::get('email-verification', 'app\Http\Controllers\AuthController@verify')->name('verification.verify');
// Route::post('register', 'Api\AuthController@register');
// Route::post('login', 'Api\AuthController@login');
 //login
 Route::post('/login', [UserController::class, 'login']);
 Route::post('/register', [UserController::class, 'store']);

Route::group(['middleware'], function(){
// SUPPLIER
Route::get('/suppliers', [SupplierController::class, 'index']);
Route::post('/suppliers', [SupplierController::class, 'store']);
Route::get('/suppliers/{id}', [SupplierController::class, 'show']);
Route::delete('/suppliers/{id}', [SupplierController::class, 'destroy']);
Route::put('/suppliers/{id}', [SupplierController::class, 'update']);
// USER
Route::get('/users', [UserController::class, 'index']);
Route::get('/users/{id}', [UserController::class, 'show']);
Route::delete('/users/{id}', [UserController::class, 'destroy']);
Route::put('/users/{id}', [UserController::class, 'update']);
// BARANG
Route::get('/barangs', [BarangController::class, 'index']);
Route::post('/barangs', [BarangController::class, 'store']);
Route::get('/barangs/{id}', [BarangController::class, 'show']);
Route::delete('/barangs/{id}', [BarangController::class, 'destroy']);
Route::put('/barangs/{id}', [BarangController::class, 'update']);
// KERANJANG
Route::get('/keranjangs', [KeranjangController::class, 'index']);
Route::post('/keranjangs', [KeranjangController::class, 'store']);
Route::get('/keranjangs/{user_id}', [KeranjangController::class, 'indexbuyer']);
Route::delete('/keranjangs/{id}', [KeranjangController::class, 'destroy']);
Route::put('/keranjangs/{id}', [KeranjangController::class, 'update']);
});

// Route::apiResource('/suppliers', App\Http\Controllers\SupplierController::class);
// Route::apiResource('/barangs', App\Http\Controllers\BarangController::class);
// Route::apiResource('/users', App\Http\Controllers\UserController::class);