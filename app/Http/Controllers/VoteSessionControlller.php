<?php

namespace App\Http\Controllers;

use App\Models\Vote;
use App\Models\Votingsession;
use Faker\Provider\Uuid;
use Illuminate\Http\Request;

class VoteSessionControlller extends Controller
{
    public $newSession;
    public $newVote;

    public function makeVotingSession(Request $request){
        //$request recibe el RoomID
        $this->newSession = new Votingsession();
        $this->newSession->VotingSessionCode = Uuid::uuid();
        $this->newSession->RoomID = $request->RoomID;
        $this->newSession->IsActive = true;
        $this->newSession->save();

        return response()->json([
            'VotingSessionCode' => $this->newSession->VotingSessionCode
        ]);

        //este metodo es activado cuando el host presiona starVoting
        //devolvemos VotingSessionCode para enviarselo al participante desde el host
    }

    public function makeVote(Request $request){
      //hacer un if para que compruebe si durante la session ese "userID" ya marco una tarjeta
      // si ya existe un voto con ese UserID y ese VotingSessionCode entonces solo actualizar la carta
      // si no existe coincidencias entonces crear el voto
      //recordar que se entrara a este metodo cada vez que se clickee una carta

        $this->newVote = new Vote();
        $this->newVote->VotingSessionCode = $request->VotingSessionCode;
        $this->newVote->UserID = $request->UserID;
        $this->newVote->vote = $request->vote; //valor de la carta seleccionada
        $this->newVote->save();
        
        return response()->json([
            'message' => "Se registro una votacion"
        ]);
    }
}
