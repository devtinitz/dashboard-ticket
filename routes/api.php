<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\TicketController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


// Route::post('/tickets', [TicketController::class, 'store']);
Route::post('/tickets', [TicketController::class, 'storeEvent']);
Route::post('/events', [TicketController::class, 'createEvent']);
// Route::post('/events', [EventController::class, 'createEvent']);

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
// Route::post('/auth/login', [AuthController::class, 'login']);

// Route::group(['middleware'=>['auth:sanctum']], function(){
//     Route::post('logout', [AuthController::class, 'logout']);
//     Route::post('refresh', [AuthController::class, 'refresh']);
//     Route::post('me', [AuthController::class, 'me']);
// });


// Route::post('/ticket', [TicketController::class, 'ticket']);