<?php

use App\Http\Controllers\ApprovalController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\OthersController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('login');
});

Auth::routes([
    'login' => false,   
    'register' => false,
]);

Route::get('/login', [LoginController::class,'showloginform'])->name('user_login');
Route::post('/login',[LoginController::class, 'login'])->name('login');
// Route::get('/register', [RegisterController::class,'showRegisterForm'])->name('user_register');
// Route::post('/register',[RegisterController::class, 'create'])->name('register');

Route::middleware(["auth:user"])->group(function(){
    Route::get('/home',[LoginController::class, 'dashboard'])->name('home');
    Route::get('/logout',[LoginController::class, 'logout'])->name('logout');

    /* User */
    Route::get('/register', [UserController::class,'showRegisterForm'])->name('user_register');
    Route::post('/register',[RegisterController::class, 'create'])->name('register');
    Route::post('/get_user', [UserController::class, 'get_user'])->name('get_user');
    Route::get('/edit_user/{id}', [UserController::class, 'get_user'])->name('edit_user');
    Route::get('/user_list', [UserController::class, 'index'])->name('user_list');
    Route::get('/user_list/{request_list}', [UserController::class, 'index'])->name('user_pending_list');
    Route::post('/approve_user', [UserController::class, 'approve_pending_user'])->name('approve_pending_user');
    Route::get('/resend_user_approve_request',[UserController::class, 'resend_user_approve_request']);

    /* Company */
    Route::get('/company_list', [CompanyController::class, 'index'])->name('company_list');
    Route::get('/company_list/{request_list}', [CompanyController::class, 'index'])->name('company_pending_list');
    Route::get('/company_create',[CompanyController::class, 'create'])->name('company_create');
    Route::get('/company_create/{id}',[CompanyController::class, 'create'])->name('company_edit');
    Route::post('/company_create',[CompanyController::class, 'store'])->name('company_store');
    Route::get('/company_details/{id}', [CompanyController::class, 'company_details'])->name('company_details');

    /* Customer */
    Route::get('/customer_list', [CustomerController::class, 'index'])->name('customer_list');
    Route::get('/customer_create',[CustomerController::class, 'create'])->name('customer_create');
    Route::post('/customer_create',[CustomerController::class, 'store'])->name('customer_store');

    /* Payment Types */
    Route::get('/payment_type_list', [OthersController::class, 'index'])->name('payment_type_list');
    Route::get('/payment_type_create',[OthersController::class, 'create'])->name('payment_type_create');
    Route::post('/payment_type_create',[OthersController::class, 'store'])->name('payment_type_store');
    
    /* Sales Types */
    Route::get('/sales_type_list', [OthersController::class, 'index'])->name('sales_type_list');
    Route::get('/sales_type_create',[OthersController::class, 'create'])->name('sales_type_create');
    Route::post('/sales_type_create',[OthersController::class, 'store'])->name('sales_type_store');
    
    /* Solutions */
    Route::get('/solution_list', [OthersController::class, 'index'])->name('solution_list');
    Route::get('/solution_create',[OthersController::class, 'create'])->name('solution_create');
    Route::post('/solution_create',[OthersController::class, 'store'])->name('solution_store');

    /* Items */
    Route::get('/item_list', [OthersController::class, 'index'])->name('item_list');
    Route::get('/item_create',[OthersController::class, 'create'])->name('item_create');
    Route::post('/item_create',[OthersController::class, 'store'])->name('item_store');

    /* Order */
    Route::get('/order_list', [OrderController::class, 'index'])->name('order_list');
    Route::get('/order_list/{request_list}', [OrderController::class, 'index'])->name('order_pending_list');
    Route::get('/order_create',[OrderController::class, 'create'])->name('order_create');
    Route::get('/order_create/{id}',[OrderController::class, 'create'])->name('order_edit');
    Route::post('/order_create',[OrderController::class, 'store'])->name('order_store');
    Route::get('/order_details/{id}', [OrderController::class, 'order_details'])->name('order_details');


    /* Approve All Pending Request */
    Route::post('/pending_list_approve', [ApprovalController::class, 'approve_request'])->name('pending_list_approve');

});

