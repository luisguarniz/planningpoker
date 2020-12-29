<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Animal;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{

    public $newUser;
    
    public function makeUser(){
        //Primero Creo un usuario
        $permitted_chars1 = '0123456789abcdefghijklmnopqrstuvwxyz';
        $userID =  substr(str_shuffle($permitted_chars1), 0, 32); //guardamos los caracteres aleatorios

        $animal = Animal::all()->random(); // con este metodo traigo un registro random
        $nomAnimal = $animal->animalName;
    
        $this->newUser = new User();
        $this->newUser ->AdminUserCode = $userID;
        $this->newUser ->NameUsuario = $nomAnimal;
        $this->newUser ->isAdmin = '1';
        $this->newUser ->save();

    //creamos un token que nos servira para la union de los usuarios
    //$token = $newUser->CreateToken('authToken')->accesToken;
    $token = $this->newUser->CreateToken('authToken')->accessToken;

    $response['NameUsuario']= $this->newUser->NameUsuario;
    $response ['AdminUserCode'] = $this->newUser->AdminUserCode ;
    $response ['$token'] = $token;
        //devolvemos el codigo de usuario por que sera incertado en un campo al crear el room de la otra tabla
        return $response;
    }

    public function me(){
        return response()->json([
            'ok' => true,
            'user' => $this->newUser
        ]);
    }
}
