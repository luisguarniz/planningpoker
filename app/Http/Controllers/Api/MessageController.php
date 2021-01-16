<?php

namespace App\Http\Controllers\Api;

use App\Events\messageTest;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    public function unblock(Request $request){
        $data = $request->only(['msgUnblock','to']);

        event(new messageTest($data));
     
        return response()->json([
            'ok'  => true,
            'message' => 'mensaje enviado correctamente',
        ]);
    }
}
