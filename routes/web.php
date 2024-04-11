<?php

use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ListTicketController;
use App\Http\Controllers\Auth\LoginController;


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


Route::get('/', function () {
    return redirect('login');
});
Route::get('/login', [LoginController::class, 'showLoginForm']);

Route::get('/ticket', [ListTicketController::class, "index"])->middleware('auth')->name("ticket");
Route::get('/dashboard', [DashboardController::class, 'index'])->middleware('auth')->name('dashboard');
Route::get('/export-to-excel', [ListTicketController::class, 'exportToExcel'])->middleware('auth')->name('export_excel');
Route::get('/export-to-pdf', [ListTicketController::class, 'exportToPDF'])->middleware('auth')->name('export_pdf');


Route::post('/login', [LoginController::class, 'authenticate'])->name('login');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');




