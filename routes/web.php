<?php


use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\HomeController;
use GuzzleHttp\Middleware;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Middleware\NoCache;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


//getting views without auth verifi
Route::prefix('admin')->middleware(['nocache'])->controller(HomeController::class)->group(function(){
      Route::get('login',  'showLogin')->name('login');
      Route::get('otp','otp');
      Route::get('register','register');
      
});

//Post Controller
Route::prefix('admin')->controller(AuthController::class)->group(function(){
    Route::post('register',  'register');
    Route::post('verify-otp', 'verifyOtp')->name('admin.verifyOtp');
    Route::post('login', 'login');
});
// dd(Auth::check(), Auth::user(), session()->all());
//getting view With Auth Verifi
Route::prefix('admin')->controller(HomeController::class)->middleware(['auth','verified'])->group(function(){
    Route::get('adminall','adminall')->name('admin.all');
    Route::get('dashboard','dashboard');
    Route::get('department-management','adddepartment')->name('add.dep');
});

Route::middleware('auth:sanctum')->group(function () {
    Route::post('admin/logout', [AuthController::class, 'logout']);
});

Route::get('/', function () {
    return view('admin.login');
});

Route::prefix('admin')->middleware(['auth','verified'])->controller(DepartmentController::class)->group(function(){
    Route::post('new-department','newDepartment')->name('new.department');
});