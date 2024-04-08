<?php

use App\Http\Controllers\Admin\DashboardController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Auth\AdminAuthenticatedSessionController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::namespace('Auth')->middleware('guest')->group(function(){
    // // login route
    // Route::get('/admin/login',[AdminAuthenticatedSessionController::class, 'create']);
    // Route::post('/admin/login',[AdminAuthenticatedSessionController::class, 'store']);
});


Route::middleware(['auth','admin',])->group(function(){
   
    Route::get('/admin/dashboard',[DashboardController::class, 'index'])->name('admin.dashboard');


    });

