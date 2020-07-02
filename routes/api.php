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


Route::namespace('Api')->name('api.')->group(function(){
    Route::prefix('fighter')->group(function(){
        Route::get('/','FighterController@index')->name('fighters_index');
    });
});

//Rotes fighters
Route::namespace('Api')->name('api.')->group(function(){
    Route::prefix('battles')->group(function(){
        Route::get('/','BattlerController@index')->name('blattes_index');
    });
});