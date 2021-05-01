<?php

use App\Http\Controllers\Api\MessageController;
use App\Http\Controllers\Api\PhrasesController;
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
Route::put("User/editNameUser",[UserController::class, 'editNameUser'])->name('user.editNameUser');

//Rutas del Invited
Route::get("User/makeInvited",[UserController::class, 'makeInvited'])->name('User.makeInvited');


//Rutas del Room
Route::post("Room/makeRoom",[RoomController::class, 'makeRoom'])->name('Room.makeRoom');
Route::put("Room/desactivateRoom",[RoomController::class, 'desactivateRoom'])->name('Room.desactivateRoom');
Route::get("Room/getRoomInvited/{RoomCode}",[RoomController::class, 'getRoomInvited'])->name('Room.getRoomInvited');
Route::get("Room/getRoomhost/{RoomCode}",[RoomController::class, 'getRoomhost'])->name('Room.getRoomhost');
Route::post("Room/makeStatus",[RoomController::class, 'makeStatus'])->name('Room.makeStatus');

Route::put("Room/changeStatusCartas",[RoomController::class, 'changeStatusCartas'])->name('Room.changeStatusCartas');
Route::get("Room/getStatusCartas/{RoomCode}",[RoomController::class, 'getStatusCartas'])->name('Room.getStatusCartas');

Route::put("Room/changeStatusbtnVoting",[RoomController::class, 'changeStatusbtnVoting'])->name('Room.changeStatusbtnVoting');
Route::get("Room/getStatusbtnVoting/{RoomCode}",[RoomController::class, 'getStatusbtnVoting'])->name('Room.getStatusbtnVoting');

Route::put("Room/changeStatusbtnStopVoting",[RoomController::class, 'changeStatusbtnStopVoting'])->name('Room.changeStatusbtnStopVoting');
Route::get("Room/getStatusbtnStopVoting/{RoomCode}",[RoomController::class, 'getStatusbtnStopVoting'])->name('Room.getStatusbtnStopVoting');

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

//ruta para mostrar participantes a los invitados despues de presionar el voton star voting
Route::get("Votingsession/getParticipants/{VotingSessionCode}",[VoteSessionControlller::class, 'getParticipants'])->name('Votingsession.getParticipants');

//ruta para desblokear las cartas de los participantes
Route::post('Message/unblock',[MessageController::class, 'unblock'])
->name('MessageController.unblock')
->middleware('auth:api');

//ruta para cambiar los nombres de los participantes
Route::post('Message/changeName',[MessageController::class, 'changeName'])
->name('MessageController.changeName')
->middleware('auth:api');

//Rutas de las frases
Route::get("Phrase/saludoHost",[PhrasesController::class, 'saludoHost'])->name('Phrase.saludoHost');
Route::get("Phrase/saludoInvited",[PhrasesController::class, 'saludoInvited'])->name('Phrase.saludoInvited');
Route::get("Phrase/PhraseFinishInvited",[PhrasesController::class, 'PhraseFinishInvited'])->name('Phrase.PhraseFinishInvited');
Route::get("Phrase/getPhraseRandom",[PhrasesController::class, 'getPhraseRandom'])->name('Phrase.getPhraseRandom');
