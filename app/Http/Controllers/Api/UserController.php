<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserLoginRequest;
use App\Models\Animal;
use App\Models\User;
use Faker\Provider\Uuid;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{

    public $newUser;
    public $newInvited;
    
    public function makeUser(){
        //Primero Creo un usuario
        //$permitted_chars1 = '0123456789abcdefghijklmnopqrstuvwxyz';
        //$userID =  substr(str_shuffle($permitted_chars1), 0, 32); //guardamos los caracteres aleatorios

        $animal = Animal::all()->random(); // con este metodo traigo un registro random
        $nomAnimal = $animal->animalName;
    
        $this->newUser = new User();
        $this->newUser->AdminUserCode = Uuid::uuid();
        $this->newUser->NameUsuario = $nomAnimal;
        $this->newUser->password = bcrypt('12345678');
        $this->newUser->isAdmin = '1';
        $this->newUser->save();
        
    //creamos un token que nos servira para la union de los usuarios
    $token = $this->newUser->CreateToken('authToken')->accessToken;

    $response['NameUsuario']= $this->newUser->NameUsuario;
    $response ['AdminUserCode'] = $this->newUser->AdminUserCode;
    $response ['token'] = $token;
        //devolvemos el codigo de usuario por que sera incertado en un campo al crear el room de la otra tabla
        return $response;
    }


    public function loginHost(Request $request){
      $data = $request->only('NameUsuario', 'password');

      if (!Auth::attempt($data)) {
          return response()->json([
           'ok'   => false,
          'message' => 'error de credenciales',
       ]);
     }

      $token = Auth::user()->createToken('authToken')->accessToken;

      return response()->json([
          'ok' => true,
          'user' => Auth::user(),
          'token' => $token
      ]);
    }


    public function me(){
        return response()->json([
            'ok' => true,
            'user' => Auth::user()
        ]);
    }

    public function makeInvited(){


        $animal = Animal::all()->random(); // con este metodo traigo un registro random
        $nomAnimal = $animal->animalName;
    
        $this->newInvited = new User();
        $this->newInvited->AdminUserCode = Uuid::uuid();
        $this->newInvited->NameUsuario = $nomAnimal;
        $this->newUser->password = bcrypt('12345678');
        $this->newInvited->isInvited = '1';
        $this->newInvited->save();
        
       $response['nameInvited']= $this->newInvited->NameUsuario;
       $response ['InvitedUserCode'] = $this->newInvited->AdminUserCode ;
        //devolvemos el codigo de usuario por que sera incertado en un campo al crear el room de la otra tabla
        return $response;
    }
}
