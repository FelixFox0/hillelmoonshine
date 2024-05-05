<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ReserveController;
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

Route::redirect('/home', '/');

Route::middleware("auth:web")->group(function () {
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

});

Route::middleware("guest:web")->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login_process', [AuthController::class, 'login'])->name('login_process');

    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register_process', [AuthController::class, 'register'])->name('register_process');

    Route::get('/forgot', [AuthController::class, 'showForgotForm'])->name('forgot');
    Route::post('/forgot_process', [AuthController::class, 'forgot'])->name('forgot_process');
});

Route::prefix('reservation')->group(function () {
    Route::get('/create', [ReserveController::class, 'showCreateReserveForm'])->name('reservation.create.form');
    Route::post('/store', [ReserveController::class, 'createReserve'])->name('reservation.store');

    Route::get('/confirm/{reserveId}', [ReserveController::class, 'showConfirmationForm'])->name('reservation.confirmation.form');
    Route::post('/confirm/{reserveId}', [ReserveController::class, 'confirmReserve'])->name('reservation.confirmation.submit');
});

Route::get('/no-times', function () {
    return view('reserve.no-times');
})->name('reservation.no-times');

