<?php

namespace App\Http\Controllers;

use App\Events\gameEvent;
use App\Models\User;
use App\Models\Vote;
use App\Models\Votingsession;
use Faker\Provider\Uuid;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PhpParser\JsonDecoder;

class VoteSessionControlller extends Controller
{
    public $newSession;
    public $newVote;

    public function makeVotingSession(Request $request)
    {
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

    public function getVotingSession(Request $request)
    {
        //   $query = Vote::where('VotingSessionCode',$request->VotingSessionCode)->Where('IsActive','1')->orderBy('vote','desc')->get();
        //  return $query;


        $query = DB::table('votes')
            ->join('users', 'users.id', '=', 'votes.UserID')
            ->select('users.NameUsuario', 'votes.UserID', 'votes.vote')
            ->where('votes.VotingSessionCode', $request->VotingSessionCode)
            //->Where('votes.IsActive', '1')
            ->orderByDesc('votes.vote')
            ->get();
        // var_dump($query); die;
        return $query;
    }

    public function setVotingParticipants(Request $request)
    {
        $nro = count($request->setVotes);
        $votes = array();
        for ($i=0; $i < $nro ; $i++) { 
            
            $vote = array();
            $vote = new Vote;
            $vote['VotingSessionCode'] = $request->setVotes[$i]['VotingSessionCode'];
            $vote['UserID'] = $request->setVotes[$i]['UserID'];
            $vote['vote'] = $request->setVotes[$i]['vote'];

            $votes[$i] = $vote;
            $vote->save();
        }
        $query = DB::table('votes')
        ->join('users', 'users.id', '=', 'votes.UserID')
        ->select('users.NameUsuario','votes.vote')
        ->where('votes.VotingSessionCode', $request->setVotes[0]['VotingSessionCode'])
        ->get();
    return $query;
}

    public function makeVote(Request $request)
    {

        $votes = Vote::where('votes.VotingSessionCode', $request->VotingSessionCode)
        ->where('votes.UserID', $request->UserID)
        ->update([
            'vote' => $request->vote
        ]);
        return response()->json([
            'message' => "Se registro una votacion"
        ]);
    }

    //QUITAR ESTE METODO POR QUE AHORA EL MAKEVOTE Actualiza el voto y no crea mas votos
    public function desactivateVote(Request $request)
    {

        $room = Vote::where('UserID', $request->UserID)->update([
            'IsActive' => '0'
        ]);
    }

    public function limpiarCartas(Request $request)
    {
        // $data = $request->only(['msgUnblock','codigoSesion','to']);

        event(new gameEvent($request));

        return response()->json([
            'ok'  => true,
            'message' => 'mensaje de limpiar cartas enviado correctamente',
        ]);
    }
}
