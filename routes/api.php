<?php

use App\Http\Controllers\Api\MessageController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\RoomController;
use App\Http\Controllers\VoteSessionControlller;
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
Route::put("Room/desactivateRoom",[RoomController::class, 'desactivateRoom'])->name('Room.desactivateRoom');
Route::get("Room/getRoomInvited/{RoomCode}",[RoomController::class, 'getRoomInvited'])->name('Room.getRoomInvited');

//Rutas de VoteSession
Route::post("Votingsession/makeVotingSession",[VoteSessionControlller::class, 'makeVotingSession'])->name('Votingsession.makeVotingSession');
Route::post("Votingsession/makeVote",[VoteSessionControlller::class, 'makeVote'])->name('Votingsession.makeVote');
Route::get("Votingsession/getVotingSession/{VotingSessionCode}",[VoteSessionControlller::class, 'getVotingSession'])->name('Votingsession.getVotingSession');
Route::post("Votingsession/setVotingParticipants",[VoteSessionControlller::class, 'setVotingParticipants'])->name('Votingsession.setVotingParticipants');
Route::put("Votingsession/desactivateVote",[VoteSessionControlller::class, 'desactivateVote'])->name('Votingsession.desactivateVote');
//ruta para borras las cartas de los participantes
Route::post('Votingsession/limpiarCartas',[VoteSessionControlller::class, 'limpiarCartas'])
->name('Votingsession.limpiarCartas')
->middleware('auth:api'); 

//ruta para desblokear las cartas de los participantes
Route::post('Message/changeIcon',[MessageController::class, 'changeIcon'])
->name('MessageController.changeIcon')
->middleware('auth:api');

//ruta para desblokear las cartas de los participantes
Route::post('Message/unblock',[MessageController::class, 'unblock'])
->name('MessageController.unblock')
->middleware('auth:api');

