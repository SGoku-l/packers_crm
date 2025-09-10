<?php

<<<<<<< HEAD
use App\Http\Controllers\HomeController;
=======
use App\Http\Controllers\AuthController;
>>>>>>> 3e53c2d (added login page)
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::view('index','admin.pages-starter');
<<<<<<< HEAD

Route::get('register',[HomeController::class,'register']);

Route::get('otp',[HomeController::class,'otp']);
=======
Route::get('login', [AuthController::class, 'showLogin']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
>>>>>>> 3e53c2d (added login page)
