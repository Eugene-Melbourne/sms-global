<?php

use App\Http\Controllers\Api\SmsGlobalController;
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

//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});


Route::group([], function () {
    Route::post('/message', [SmsGlobalController::class, 'post_message'])
        ->name('message-post');

    Route::get('/message', [SmsGlobalController::class, 'get_message'])
        ->name('message-get');
});
