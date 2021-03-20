<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Phrase;
use Illuminate\Http\Request;

class PhrasesController extends Controller
{
    public function saludoHost(){
        $saludo = Phrase::where('idkindphrase', 1)->get()->random();
        return response()->json([
            'saludo' => $saludo
          ]);
    }

    public function saludoInvited(){
        $saludo = Phrase::where('idkindphrase', 2)->get()->random();
        return response()->json([
            'saludo' => $saludo
          ]);
    }
 
    public function PhraseFinishInvited(){
        $saludo = Phrase::where('idkindphrase', 6)->get()->random();
        return response()->json([
            'saludo' => $saludo
          ]);
    }
    public function getPhraseRandom(){
        $saludo = Phrase::where('idkindphrase', 7)->get()->random();
        return response()->json([
            'saludo' => $saludo
          ]);
    }
}
