<?php

namespace App\Http\Controllers;

use App\Models\Animal;
use App\Models\City;
use App\Models\Room;
use App\Models\User;
use Illuminate\Http\Request;

class RoomController extends Controller
{
  public function makeRoom()
  {

    //Primero Creo un usuario
    $permitted_chars1 = '0123456789abcdefghijklmnopqrstuvwxyz';
    $userID =  substr(str_shuffle($permitted_chars1), 0, 32); //guardamos los caracteres aleatorios

    $animal = Animal::all()->random(); // con este metodo traigo un registro random
    $nomAnimal = $animal->animalName;

    $newUser = new User;
    $newUser->AdminUserCode = $userID;
    $newUser->NameUsuario = $nomAnimal;
    $newUser->isAdmin = '1';
    $newUser->save();

    $permitted_chars1 = '0123456789abcdefghijklmnopqrstuvwxyz';
    $roomID =  substr(str_shuffle($permitted_chars1), 0, 32); //guardamos los caracteres aleatorios
    $admCode = $newUser->AdminUserCode;

    $ciudad = City::all()->random(); // con este metodo traigo un registro random
    $nomCiudad = $ciudad->CityName;
    $permitted_chars2 = '0123456789';
    $roomName = $nomCiudad . '-' . substr(str_shuffle($permitted_chars2), 0, 4);



    $permitted_chars3 = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $roomCodeLetras = substr(str_shuffle($permitted_chars3), 0, 3);
    $permitted_chars4 = '0123456789';
    $roomCodeNumeros = substr(str_shuffle($permitted_chars4), 0, 3); //guardamos los caracteres aleatorios


    $newRoom = new Room;
    $newRoom->RoomID = $roomID;
    $newRoom->AdminUserCode = $admCode;
    $newRoom->RoomName = $roomName;
    $newRoom->RoomCode = $roomCodeLetras . $roomCodeNumeros;

    $newRoom->save();

    //creamos un token que nos servira para la union de los usuarios
    //$token = $newUser->CreateToken('authToken')->accesToken;
    $token = $newUser->createToken('authToken')->accessToken;
    //una ves creada la sala con save() pasamos a retornar un objeto a la vista
    $response['RoomName']= $newRoom->RoomName;
    $response['RoomCode']= $newRoom->RoomCode;
    $response['NameUsuario']= $newUser->NameUsuario;
    $response['AdminUserCode'] = $newRoom->AdminUserCode;
    $response['token'] = $token;
    return $response;
  }

 
  public function deactivateRoom($id){
           $room = Room::where('AdminUserCode',$id)->update([
            'IsActive'=> '0'
           ]);
  }
}

