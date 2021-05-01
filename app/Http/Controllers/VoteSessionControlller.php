<?php

namespace App\Http\Controllers;

use App\Events\gameEvent;
use App\Models\Phrase;
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
    public $variable = false;
    public $saludo;

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
        //$frase = Finishvotinghost::all()->random();
        $frase = Phrase::where('idkindphrase', 5)->get()->random();

        $query = DB::table('votes')
            ->join('users', 'users.id', '=', 'votes.UserID')
            ->select('users.NameUsuario','users.CustomName', 'votes.UserID', 'votes.vote')
            ->where('votes.VotingSessionCode', $request->VotingSessionCode)
            //->Where('votes.IsActive', '1')
            ->orderBy('votes.vote', 'desc')
            ->get();
        //return $query;
        return response()->json([
            'votos' => $query,
            'saludo' => $frase
          ]);
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
        ->select('users.id','users.NameUsuario','votes.vote','users.CustomName')
        ->where('votes.VotingSessionCode', $request->setVotes[0]['VotingSessionCode'])
        ->get();
    return $query;
}

public function getVotingParticipants(Request $request){

    $query = DB::table('votes')
    ->join('users', 'users.id', '=', 'votes.UserID')
    ->select('users.id','users.NameUsuario','votes.vote','users.CustomName')
    ->where('votes.VotingSessionCode', $request->VotingSessionCode)
    ->get();
return $query;
}

    public function makeVote(Request $request)
    {
        
        // consultar  si todos los votos de $request->VotingSessionCode son null entonces consultar la tabla phrasesfirstvotes
        // pero si hay almenos un voto que no es null entonces consultar la tabla phrasesvotes
        // devolver la frase random segun la tabla que se consulto
        $votesall = Vote::where('votes.VotingSessionCode', $request->VotingSessionCode)->get();

        for ($i=0; $i < count($votesall); $i++) { 
            if ($votesall[$i]->vote !== null) {
                $this->variable = true;
            }else {
                $this->variable = false;
            }
        }

        $votes = Vote::where('votes.VotingSessionCode', $request->VotingSessionCode)
        ->where('votes.UserID', $request->UserID)
        ->update([
            'vote' => $request->vote
        ]);

        if ($this->variable == true) {
            $this->saludo = Phrase::where('idkindphrase', 4)->get()->random();
            return response()->json([
              $this->saludo->Phrase
              ]);

        }else {
             $this->saludo = Phrase::where('idkindphrase', 3)->get()->random();
            return response()->json([
              $this->saludo->Phrase
              ]);
        }
       // return response()->json([
         //   'message' => "Se registro una votacion"
        //]);
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

    public function getParticipants(Request $request)
    {

        $query = DB::table('votes')
            ->join('users', 'users.id', '=', 'votes.UserID')
            ->select('users.id','users.NameUsuario','users.CustomName','votes.UserID')
            ->where('votes.VotingSessionCode', $request->VotingSessionCode)
            ->get();
        return response()->json([
            'participantes' => $query
          ]);
    }
}
