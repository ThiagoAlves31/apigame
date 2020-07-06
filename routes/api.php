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
    Route::prefix('fighters')->group(function(){
        Route::get('/','FighterController@index')->name('Fighters_index');
        //Route::post('/','BattlerController@create')->name('blattes_create');
    });
});

Route::namespace('Api')->name('api.')->group(function(){
    Route::prefix('battles')->group(function(){
        Route::get('/','BattlerController@index')->name('blattes_index');
        Route::post('/','BattlerController@create')->name('blattes_create');
    });
});

Route::namespace('Api')->name('api.')->group(function(){
    Route::prefix('rounds')->group(function(){
        Route::get('/','RoundController@index')->name('rounds_index');
        Route::post('/{battle_id}','RoundController@create')->name('rounds_create');
    });
});

Route::namespace('Api')->name('api.')->group(function(){
    Route::prefix('weapons')->group(function(){
        Route::get('/','WeaponController@index')->name('weapons_index');
        //Route::post('/{battle_id}','RoundController@create')->name('weapons_create');
    });
});