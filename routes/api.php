<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

/*Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});*/

/*Route::group([
    'middleware' => 'api',
    'namespace' => 'App\Http\Controllers',
    'prefix' => 'auth'
], function ($router) {
    Route::post('login', 'AuthController@login');
    Route::post('logout', 'AuthController@logout');
    Route::post('refresh', 'AuthController@refresh');
    Route::get('me', 'AuthController@me');
});*/

Route::group([
    'middleware' => 'api',
    'namespace' => 'App\Http\Controllers',
    'prefix' => 'auth'
], function () {
    Route::post('login', 'AuthController@login');
    Route::Post('register', 'AuthController@register');
    Route::Get('userAll', 'AuthController@userAll');

    Route::middleware('auth.jwt')->group(function () {

         /*users controller*/
         Route::Post('logout', 'AuthController@logout');
         Route::get('refresh', 'AuthController@refresh');
         Route::get('userSession', 'AuthController@userSession');

         /*institutions controller*/
         Route::get('listAllInstutions', 'InstitutionController@listAllInstutions')->name('listAllInstutions');


    });
});



