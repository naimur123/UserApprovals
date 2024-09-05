<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('register');
});

Auth::routes([
    'login' => false,   
    'register' => false,
]);

Route::get('/login', [LoginController::class,'showloginform'])->name('user_login');
Route::post('/login',[LoginController::class, 'login'])->name('login');
Route::get('/register', [RegisterController::class,'showRegisterForm'])->name('user_register');
Route::post('/register',[RegisterController::class, 'create'])->name('register');

Route::middleware(["auth:user"])->group(function(){
    Route::get('/home',[LoginController::class, 'dashboard'])->name('home');
    Route::get('/logout',[LoginController::class, 'logout'])->name('logout');

    Route::post('/get_user', [UserController::class, 'get_user'])->name('get_user');
    Route::get('/user_list', [UserController::class, 'index'])->name('user_list');
    Route::get('/user_list/{request_list}', [UserController::class, 'index'])->name('user_pending_list');
    Route::post('/approve_user', [UserController::class, 'approve_pending_user'])->name('approve_pending_user');
    Route::get('/resend_user_approve_request',[UserController::class, 'resend_user_approve_request']);
});
// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
