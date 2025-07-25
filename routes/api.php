<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
test 4
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();  
});

Route::group(['middleware' => ['sometimes.auth']], function () {

});

Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::get('/v1/logout','App\Http\Controllers\AuthController@logout');
});

    Route::post('/v1/register','App\Http\Controllers\AuthController@register');
    Route::post('/v1/login','App\Http\Controllers\AuthController@login');