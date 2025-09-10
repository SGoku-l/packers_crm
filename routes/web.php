<?php

use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::view('index','admin.pages-starter');

Route::get('register',[HomeController::class,'register']);

Route::get('otp',[HomeController::class,'otp']);