<?php

use App\Http\Controllers\ActionLogController;
use App\Http\Controllers\AnalyticsController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\GasDetectionController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SendDataController;
use App\Models\GasDetection;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

Route::get('/', function () {
    return redirect('/login');
});

//for test//////////////////////////////////
Route::get('/demo-request', function() {
    return response()->json(Auth::user());
});
Route::post('/demo-post', function (Request $request) {
    log::debug($request);
});
/////////////////////////////////////////////
///////////// Dashboard ////////////////
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/dashData', [DashboardController::class, 'dashboard'])
    ->middleware(['auth', 'verified']);

Route::get('/get-users', [DashboardController::class, 'get_users']);

Route::delete('/destroy-user/{user}', [DashboardController::class, 'destroy_user']);
/////////////////////////////////////////////
///////////// Analytics ////////////////

Route::get('/analytics', function () {
    return view('analytics');
})->middleware(['auth', 'verified'])->name('analytics');

Route::get('/get-dates/{date?}', [AnalyticsController::class, 'getDays']);

Route::get('/ph-over-time/{date?}', [AnalyticsController::class, 'ph_over_time']);

Route::get('/temp-over-time/{date?}', [AnalyticsController::class, 'temp_over_time']);

Route::get('/avg-ph/{date?}', [AnalyticsController::class, 'avg_ph']);

Route::get('/avg-temp/{date?}', [AnalyticsController::class, 'avg_temp']);

/////////////////////////////////////////////
///////////// Actions Log ////////////////
Route::get('/actions', function () {
    return view('actions');
})->middleware(['auth', 'verified'])->name('actions');

Route::get('/index', [ActionLogController::class, 'index']);

Route::post('/search', [ActionLogController::class, 'search']);

/////////////////////////////////////////////
///////////// Profile Authentication ////////////////
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
///////////////////////////////////////////////////////////
/////////send data from esp end point /////////////////////

Route::get('/data/{ph}/{temp}/{state}', [SendDataController::class, 'index'])->name('data');
//////////////////////////////////////////////////////////
/////////check for gas detection /////////////////////
///
Route::get('/check', [GasDetectionController::class, 'check_gas']);
Route::get('/done/{GasDetection}', [GasDetectionController::class, 'mark_as_read']);

///////////////////////////////
/// for test only ////////////
Route::get('/add-gas', [GasDetectionController::class, 'add_gas']);

require __DIR__.'/auth.php';
