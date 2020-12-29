<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Broadcast;
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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


//Route::post('User/register',  [AuthController::class, 'register'])->name('UserController.register');
//Route::post('User/login',  [AuthController::class, 'login'])->name('UserController.login');
//Route::get('User/me',  [AuthController::class, 'me'])->name('UserController.me')->middleware('auth:api');



