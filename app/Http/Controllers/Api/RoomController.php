<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\City;
use Illuminate\Http\Request;
use App\Models\Room;
use Faker\Provider\Uuid;

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
    $newRoom->AdminUserCode = $request->AdminUserCode;// es lo que traigo en los parametros de la funcion
    $newRoom->RoomName = $roomName;
    $newRoom->RoomCode = $roomCodeLetras . $roomCodeNumeros;
    $newRoom->save();


    //una ves creada la sala con save() pasamos a retornar un objeto a la vista
    $response['RoomName']= $newRoom->RoomName;
    $response['RoomCode']= $newRoom->RoomCode;
    $response['NameUsuario']= $request->NameUsuario;// es lo que traigo en los parametros de la funcion
    $response['AdminUserCode'] = $newRoom->AdminUserCode;
    $response['token'] = $request->token;// es lo que traigo en los parametros de la funcion
    return $response;
  }

 
  public function deactivateRoom(Request $request){
           $room = Room::where('AdminUserCode',$request->RoomID)->update([
            'IsActive'=> '0'
           ]);
  }
}