<?php


use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\HomeController;
use GuzzleHttp\Middleware;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Middleware\NoCache;
use Illuminate\Support\Facades\Request;

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
    Route::post('logout', 'logout');
});
// dd(Auth::check(), Auth::user(), session()->all());
//getting view With Auth Verifi

Route::prefix('admin')->controller(HomeController::class)->middleware(['auth','verified'])->group(function(){
    Route::get('admin-management','adminall')->name('admin.all')->middleware('permission:view');
    Route::get('dashboard','dashboard');
    Route::get('department-management','adddepartment')->name('add.dep')->middleware('permission:view');
     Route::get('viewdep','viewdep')->name('view.dep');
});

// Route::middleware('auth:sanctum')->group(function () {
//     Route::post('admin/logout', [AuthController::class, 'logout']);
// });

Route::get('/', function () {
    return view('admin.login');
});

Route::prefix('admin')->middleware(['auth','verified'])->controller(DepartmentController::class)->group(function(){
    Route::post('new-department','newDepartment')->name('new.department')->middleware('permission:create');
    Route::get('departments/{id}','getDepartment')->middleware('permission:view');
    Route::put('departments/{id}','updateDepartmnet')->middleware('permission:edit');
    Route::delete('departments/{id}','destroy')->middleware('permission:delete');
    Route::post('new-admin','newAdmin')->name('new.admin');
    Route::get('admin/{id}','getAdmin');
    Route::put('adminup/{id}','updateAdmin');
    Route::delete('admindes/{id}','destroyAdmin');
    Route::get('admin-all','adminalll')->name('admin.alldata');
});
