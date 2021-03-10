<?php

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
Route::namespace('App\Http\Controllers')->group(function () {
    Route::post('login', 'Auth\AuthController@login');
    Route::namespace('Guest')->group(function () {
        Route::prefix('jobs')->namespace('Jobs')->group(function () {
            Route::get('', 'JobController@index');
            Route::get('{job_id}', 'JobController@show');
            Route::post('{job_id}/apply', 'JobController@apply');
        });
    });

    Route::prefix('my')->middleware('auth:api')->namespace('Business')->group(function () {
        Route::prefix('jobs')->namespace('Jobs')->group(function () {
            Route::get('', 'JobController@index');
            Route::post('', 'JobController@store');
            Route::post('{job_id}', 'JobController@update');
            Route::delete('{job_id}', 'JobController@delete');
        });
    });
});
