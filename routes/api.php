<?php

use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\RoomController;
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

//Rutas del Host
Route::get("User/makeUser",[UserController::class, 'makeUser'])->name('User.makeUser');
Route::post("User/loginHost",[UserController::class, 'loginHost'])->name('api.auth.login');
Route::get('User/me',[UserController::class, 'me'])
->name('UserController.me')
->middleware('auth:api');

//Rutas del Invited
Route::get("User/makeInvited",[UserController::class, 'makeInvited'])->name('User.makeInvited');


//Rutas del Room
Route::post("Room/makeRoom",[RoomController::class, 'makeRoom'])->name('Room.makeRoom');
//Route::get("Room/obtenerCiudad",[RoomController::class, 'obtenerCiudad'])->name('Room.obtenerCity');
Route::put("Room/deactivateRoom",[RoomController::class, 'deactivateRoom'])->name('Room.deactivateRoom');
