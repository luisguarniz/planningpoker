<?php

use Illuminate\Support\Facades\Broadcast;

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

Broadcast::channel('channel-test', function ($user){
    return $user;
});

//uniendose diferenciando por host
//Broadcast::channel('channel-test.{roomCode}', function ($user, $roomCode){
 //   if ($user->canJoinRoom($roomCode)) {
 //      return ['id' => $user->id, 'name' => $user->NameUsuario];
 //  }
//});