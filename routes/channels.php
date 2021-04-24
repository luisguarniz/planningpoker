<?php

use Illuminate\Support\Facades\Broadcast;
use SebastianBergmann\Environment\Console;

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
// TODO: validar existencia sala
Broadcast::channel('room.{id}', function ($room) {
    return $room;
});

// ruta para cambiar nombre
Broadcast::channel('changeName.{id}', function ($changeName) {
    return $changeName;
});

// TODO: validar existencia del usuario
Broadcast::channel('votation.{id}', function ($user, $id) {
   return (int) $user->AdminUserCode === (int) $id;
       // return $user;
});
