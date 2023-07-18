<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\JwtTokenVerify;
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
});


Route::get('/dashboard', [DashboardController::class, 'dashboardPage']);
Route::get('/register', [UserController::class, 'registrationPage'])->name('register');
Route::get('/login', [UserController::class, 'loginPage'])->name('login');
Route::get('/forgot-password', [UserController::class, 'otpPage'])->name('forgot-password');
Route::get('/verify-otp', [UserController::class, 'otpVerifyPage'])->name('verify-otp');
Route::get('/reset-password', [UserController::class, 'resetPasswordPage'])->name('reset-password')->middleware([JwtTokenVerify::class]);


Route::post('/register', [UserController::class, 'userRegistration']);
Route::post('/login', [UserController::class, 'userLogin']);
Route::post('/forgot-password', [UserController::class, 'sendOtp']);
Route::post('/verify-otp', [UserController::class, 'verifyOtp']);
Route::post('/reset-password', [UserController::class, 'resetPassword']);
