<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\City;
use Illuminate\Http\Request;
use App\Models\Room;
use App\Models\Statu;
use Faker\Provider\Uuid;
use Illuminate\Support\Facades\DB;
use Mockery\Undefined;

class RoomController extends Controller
{
  //este metodo espera el codigo y el token que devuelve la tabla user
  public function makeRoom(Request $request)
  {

    $ciudad = City::all()->random(); // con este metodo traigo un registro random
    $nomCiudad = $ciudad->CityName;
    $permitted_chars2 = '0123456789';
    $roomName = $nomCiudad . '-' . substr(str_shuffle($permitted_chars2), 0, 4);


    $permitted_chars3 = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $roomCodeLetras = substr(str_shuffle($permitted_chars3), 0, 3);
    $permitted_chars4 = '0123456789';
    $roomCodeNumeros = substr(str_shuffle($permitted_chars4), 0, 3); //guardamos los caracteres aleatorios


    $newRoom = new Room;
    $newRoom->RoomID = Uuid::uuid();
    $newRoom->idAdmin = $request->idAdmin; // es lo que traigo en los parametros de la funcion
    $newRoom->RoomName = $roomName;
    $newRoom->RoomCode = $roomCodeLetras . $roomCodeNumeros;
    $newRoom->save();


    //una ves creada la sala con save() pasamos a retornar un objeto a la vista
    $response['RoomID'] = $newRoom->RoomID;
    $response['RoomName'] = $newRoom->RoomName;
    $response['RoomCode'] = $newRoom->RoomCode;
    $response['idAdmin'] = $newRoom->idAdmin;
    return $response;
  }


  public function desactivateRoom(Request $request)
  {

    $room = Room::where('idAdmin', $request->idAdmin)->update([
      'IsActive' => '0'
    ]);
  }

  public function getRoomInvited(Request $request)
  {
    $message = null;
    $room = Room::where('RoomCode',$request->RoomCode)->first();

    if ($room == null) {
      return $message;
    }
    return response()->json([

      'RoomNameI' => $room->RoomName,
      'RoomCodeI' => $room->RoomCode
    ]);
  }

  public function getRoomhost(Request $request)
  {
    $message = null;
    $room = Room::where('RoomCode',$request->RoomCode)->first();

    if ($room == null) {
      return $message;
    }
    return response()->json([

      'RoomID'=>$room->RoomID,
      'RoomName' => $room->RoomName,
      'RoomCode' => $room->RoomCode,
      'idAdmin'=> $room->idAdmin
    ]);
  }

  public function makeStatus(Request $request)
  {
      $this->newStatu = new Statu();
      $this->newStatu->RoomCode = $request->RoomCode;
      $this->newStatu->save();

      return response()->json([
          'message' => "Se creo un registro para estado"
      ]);
  }

  public function changeStatus(Request $request)
  {


    $newName = Statu::where('status.RoomCode', $request->RoomCode)
      ->update([
        'bloquear' => $request->bloquear
      ]);

    return response()->json([
      'messagge' => "se modifico el estado"
    ]);
  }

  public function getStatus(Request $request)
  {

        $query = DB::table('status')
            ->select('status.bloquear')
            ->where('status.RoomCode', $request->RoomCode)
            ->get();
            return $query;
            return response()->json([
              'bloquear' => $query
            ]);
  }
}
