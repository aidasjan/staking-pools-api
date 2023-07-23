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

Route::middleware('auth:sanctum')->get('/users/self', 'App\Http\Controllers\UserController@self')->name('api.user.self');
Route::middleware('auth:sanctum')->put('/users/self', 'App\Http\Controllers\UserController@updateSelf')->name('api.user.updateSelf');

Route::post('/auth/challenge', 'App\Http\Controllers\AuthController@challenge')->name('api.auth.challenge');
Route::post('/auth/login', 'App\Http\Controllers\AuthController@login')->name('api.auth.login');

