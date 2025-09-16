<?php


use App\Http\Controllers\HomeController;
use GuzzleHttp\Middleware;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::post('admin/register', [AuthController::class, 'register']);
Route::post('admin/verify-otp', [AuthController::class, 'verifyOtp']);
Route::post('admin/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('admin/logout', [AuthController::class, 'logout']);
});

Route::get('/', function () {
    return view('welcome');
});

Route::get('admin/dashboard',[HomeController::class,'dashboard'])->middleware(['auth','verified']);

Route::get('register',[HomeController::class,'register']);

Route::get('admin/otp',[HomeController::class,'otp']);

Route::get('admin/login', [HomeController::class, 'showLogin'])->name('login');

