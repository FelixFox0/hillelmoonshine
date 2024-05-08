<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
})->name('home');

// Route::redirect('/home', '/');

// Route::middleware("auth:web")->group(function () {
//     Route::get('/logout', [\App\Http\Controllers\AuthController::class, 'logout'])->name('logout');

// });

// Route::middleware("guest:web")->group(function () {
//     Route::get('/login', [\App\Http\Controllers\AuthController::class, 'showLoginForm'])->name('login');
//     Route::post('/login_process', [\App\Http\Controllers\AuthController::class, 'login'])->name('login_process');

//     Route::get('/register', [\App\Http\Controllers\AuthController::class, 'showRegisterForm'])->name('register');
//     Route::post('/register_process', [\App\Http\Controllers\AuthController::class, 'register'])->name('register_process');

//     Route::get('/forgot', [\App\Http\Controllers\AuthController::class, 'showForgotForm'])->name('forgot');
//     Route::post('/forgot_process', [\App\Http\Controllers\AuthController::class, 'forgot'])->name('forgot_process');
// });

Route::get('/create', [App\Http\Controllers\ReservationController::class, 'create'])->name('create');
Route::post('/store', [App\Http\Controllers\ReservationController::class, 'store'])->name('store');
Route::post('/confirm', [App\Http\Controllers\ReservationController::class, 'confirm'])->name('confirm');
Route::get('/success', function () {
    return view('success');
})->name('success');

// Route::controller(App\Http\Controllers\ReservationController::class)->group(function() {
//     Route::post('/store', 'store');
//     Route::post('/confirm', 'confirm');
// });

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
