<?php

use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\HomeController;
use GuzzleHttp\Middleware;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Middleware\NoCache;
use Illuminate\Support\Facades\Request;
use App\Http\Controllers\LeadController;
use App\Http\Controllers\SettingsController;

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
    Route::get('admin-management','adminall')->name('admin.all')->middleware('permission:admin.view');
    Route::get('dashboard','dashboard');
    Route::get('department-management','adddepartment')->name('add.dep')->middleware('permission:dep.view');
    Route::get('viewdep','viewdep')->name('view.dep');
    Route::get('lead-statuses-sources','leadstatus')->name('lead.statuses.sources');
});

// Route::middleware('auth:sanctum')->group(function () {
//     Route::post('admin/logout', [AuthController::class, 'logout']);
// });

Route::get('/', function () {
    return view('admin.login');
});

Route::prefix('admin')->middleware(['auth','verified'])->controller(DepartmentController::class)->group(function(){
    Route::post('new-department','newDepartment')->name('new.department')->middleware('permission:dep.create');
    Route::get('departments/{id}','getDepartment')->middleware('permission:dep.view');
    Route::put('departments/{id}','updateDepartmnet')->middleware('permission:dep.edit');
    Route::delete('departments/{id}','destroy')->middleware('permission:dep.delete');
    Route::post('new-admin','newAdmin')->name('new.admin')->middleware('permission:admin.create');
    Route::get('admin/{id}','getAdmin')->middleware('permission:admin.view');
    Route::put('adminup/{id}','updateAdmin')->middleware('permission:admin.edit');
    Route::delete('admindes/{id}','destroyAdmin')->middleware('permission:admin.delete');
    Route::get('admin-all','adminalll')->name('admin.alldata')->middleware('permission:admin.view');
});

Route::prefix('admin')->middleware(['auth','verified'])->controller(LeadController::class)->group(function(){

    Route::get('lead-statuses-fetch-api','leadstatues')->name('lead.statuses.index');
    Route::post('lead-statuses-store-api','leadstatusstore');
    Route::put('lead-statuses-update-api/{id}','leadstatusupdate');
    Route::put('lead-statuses-toggle-api/{id}/toggle','leadstatustoggle');
    Route::delete('lead-statuses-delete-api/{id}','leadstatusdelete');

    Route::get('lead-source-fetch-api','leadsource')->name('lead.sources.index');
    Route::post('lead-source-store-api','leadsourcestore');
    Route::put('lead-source-update-api/{id}','leadsourceupdate');
    Route::put('lead-source-toggle-api/{id}/toggle','leadsourcetoggle');
    Route::delete('lead-source-delete-api/{id}','leadsourcedelete');

    Route::get('lead-followmethod-fetch-api','leadfollowmethod')->name('follow.methods.index');
    Route::post('lead-followmethod-store-api','leadfollowmethodstore');
    Route::put('lead-followmethod-update-api/{id}','leadfollowmethodupdate');
    Route::put('lead-followmethod-toggle-api/{id}/toggle','leadfollowmethodtoggle');
    Route::delete('lead-followmethod-delete-api/{id}','leadfollowmethoddelete');
    
});

Route::prefix('admin')->middleware(['auth','verified'])->controller(SettingsController::class)->group(function(){

    Route::get('profile-setting-page','profilepage')->name('profile.page');
    Route::post('profile-pic','profileImage')->name('profile.pic');
    Route::post('/profile/update','profileInformation')->name('profile.updateInfo');

});