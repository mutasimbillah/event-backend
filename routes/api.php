<?php

use App\Http\Controllers\Api\ApiController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\EventController;
use App\Http\Controllers\Api\NotificationController;
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

Route::get('/test', function () {
    return "Welcome";
});
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);


// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::group(['middleware' => ['auth:api']], function () {
    Route::get('user', [ApiController::class, 'user']);
    Route::apiResource('/notification', NotificationController::class)->only(['index', 'show']);
});

Route::group(['middleware' => ['auth:api', 'role:admin']], function () {
    Route::put('/update', [EventController::class, 'update']);
    Route::apiResource('/notification', NotificationController::class)->only(['store', 'index', 'show']);
});

//Route::apiResource('/events', EventController::class)->only(['update']);
