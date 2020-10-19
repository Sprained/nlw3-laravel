<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('orphanages', 'App\Http\Controllers\OrphanageController@index');
Route::get('orphanages/{id}', 'App\Http\Controllers\OrphanageController@show');
Route::post('orphanages', 'App\Http\Controllers\OrphanageController@store');