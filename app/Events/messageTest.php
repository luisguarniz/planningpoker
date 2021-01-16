<?php

namespace App\Events;

use BeyondCode\LaravelWebSockets\WebSockets\Channels\PrivateChannel as ChannelsPrivateChannel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class messageTest implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

   // public $roomID;
   // public $message; // para ser leida fuera del broadcast tiene que ser publica
    public $response;
    /**
     * Create a new event instance.
     *
     * @return void
     */                         //User $user
    public function __construct($data)
    {
    
        $this->response = [
            'msgUnblock'   => $data['msgUnblock'],
            'to'           => $data['to'],
            'from'         => auth()->user(),
        ];
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
      // return new PrivateChannel('channel-test');
       return new PrivateChannel("room.{$this->response['to']}");
    }
}
