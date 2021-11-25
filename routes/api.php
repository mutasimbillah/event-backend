<?php

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



Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['middleware' => ['auth:api']], function () {
    Route::put('/update/{event:user_id}', [EventController::class, 'update']);
    Route::post('/notification', [NotificationController::class, 'store']);
});

// Route::group(['middleware' => ['auth:api', 'role:super']], function () {
//     Route::get('/user', function (Request $request) {
//         return $request->user();
//     });
// });

//Route::apiResource('/events', EventController::class)->only(['update']);
