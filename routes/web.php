<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ChangePasswordController;
use App\Http\Controllers\HomeController;
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
Route::get('/login', [AuthController::class,'showFormLogin'] )->name('login');
Route::post('/login',[AuthController::class,'login'])->name('login.submit');
Route::get('/register', [AuthController::class,'showFormRes'])->name('showFormRes');
Route::post('/register', [AuthController::class,'register'])->name('register');
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/logout',[AuthController::class,'logout'])->name('logout');
Route::get('/changePassword',[ChangePasswordController::class,'changePassword'])->name('changePassword');
Route::post('/changePassword',[ChangePasswordController::class,'updatePassword'])->name('updatePassword');
Route::get('/my-profile',[\App\Http\Controllers\UserController::class,'showProfile'])->name('my-profile');
Route::post('/my-profile', [\App\Http\Controllers\UserController::class,'updateProfile'])->name('profile.update');
