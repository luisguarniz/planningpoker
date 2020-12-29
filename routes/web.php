<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\UserController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!

*/

Route::get('/',HomeController::class);

Route::post("Room/makeRoom",[RoomController::class, 'makeRoom'])->name('Room.makeRoom');
//Route::get("User/makeUser",[UserController::class, 'makeUser'])->name('User.makeUser');
//Route::get("Room/obtenerCiudad",[RoomController::class, 'obtenerCiudad'])->name('Room.obtenerCity');
Route::put("Room/deactivateRoom",[RoomController::class, 'deactivateRoom'])->name('Room.deactivateRoom');

Route::post('users/{id}', function ($id) {
    
});
