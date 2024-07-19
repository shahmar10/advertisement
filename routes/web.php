<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Site\HomeController;
use App\Http\Controllers\Site\Auth\RegisterController;
use App\Http\Controllers\Site\Auth\LoginController;
use App\Http\Controllers\Site\Advertisement\CreateController;
use App\Http\Controllers\Site\Advertisement\StoreController;

Route::get('/', [HomeController::class, 'index'])->name('index');
Route::get('/show/{id}', [HomeController::class, 'show'])->name('show');
Route::get('/create', [CreateController::class, 'create'])->name('create');
Route::post('/store', [StoreController::class, 'store'])->name('store');

Route::get('/register', [RegisterController::class, 'registerPage'])->name('register');
Route::post('/register', [RegisterController::class, 'register'])->name('register.submit');
Route::get('/register-confirm/{user_id}', [RegisterController::class, 'registerConfirmPage'])->name('register.confirm');
Route::post('/register-confirm/{user_id}', [RegisterController::class, 'registerConfirm'])->name('register.confirm.submit');

Route::get('/login', [LoginController::class, 'loginPage'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.submit');
Route::get('/login-confirm/{user_id}', [LoginController::class, 'loginConfirmPage'])->name('login.confirm');
Route::post('/login-confirm/{user_id}', [LoginController::class, 'loginConfirm'])->name('login.confirm.submit');

Route::get('/logout', [LoginController::class, 'logout'])->name('logout');


