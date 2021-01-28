<?php

namespace App\Http\Controllers;

use App\Events\gameEvent;
use App\Models\Vote;
use App\Models\Votingsession;
use Faker\Provider\Uuid;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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

    public function getVotingSession(Request $request){
        //   $query = Vote::where('VotingSessionCode',$request->VotingSessionCode)->Where('IsActive','1')->orderBy('vote','desc')->get();
         //  return $query;


           $query = DB::table('votes')
            ->join('users', 'users.id', '=', 'votes.UserID')
            ->select('users.NameUsuario', 'votes.UserID', 'votes.vote')
            ->where('votes.VotingSessionCode',$request->VotingSessionCode)
            ->Where('votes.IsActive','1')->orderBy('votes.vote','asc')
            ->get();
            // var_dump($query); die;
         return $query;

    }

    public function makeVote(Request $request){


        $this->newVote = new Vote();
        $this->newVote->VotingSessionCode = $request->VotingSessionCode;
        $this->newVote->UserID = $request->UserID;
        $this->newVote->vote = $request->vote; //valor de la carta seleccionada
        $this->newVote->save();
        
        return response()->json([
            'message' => "Se registro una votacion"
        ]);
    }

    public function desactivateVote(Request $request){
      
        $room = Vote::where('UserID', $request->UserID)->update([
            'IsActive' => '0'
          ]);
    }

    public function limpiarCartas(Request $request){
        // $data = $request->only(['msgUnblock','codigoSesion','to']);
 
         event(new gameEvent($request));
      
         return response()->json([
             'ok'  => true,
             'message' => 'mensaje de limpiar cartas enviado correctamente',
         ]);
     }
}
