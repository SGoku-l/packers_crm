<?php


use App\Http\Controllers\HomeController;
use GuzzleHttp\Middleware;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('index',[HomeController::class,'dashboard'])->middleware(['auth','verified']);

Route::get('register',[HomeController::class,'register']);

Route::get('otp',[HomeController::class,'otp']);

Route::get('login', [HomeController::class, 'showLogin'])->name('login');
