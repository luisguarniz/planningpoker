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

  public function makeUser()
  {
    //Primero Creo un usuario
    $permitted_chars1 = '0123456789abcdefghijklmnopqrstuvwxyz';
    $nrorandom =  substr(str_shuffle($permitted_chars1), 0, 4); //guardamos los caracteres aleatorios

    $animal = Animal::all()->random(); // con este metodo traigo un registro random
    $nomAnimal = $animal->animalName;

    $this->newUser = new User();
    $this->newUser->AdminUserCode = Uuid::uuid();
    $this->newUser->NameUsuario = $nomAnimal . $nrorandom;
    $this->newUser->password = bcrypt('12345678');
    $this->newUser->isAdmin = '1';
    $this->newUser->save();

    //creamos un token que nos servira para la union de los usuarios
    $token = $this->newUser->CreateToken('authToken')->accessToken;



    return response()->json([
      'ok'  => true,
      'user' => $this->newUser,
      'token' => $token
    ]);
  }

  public function loginHost(Request $request)
  {
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


  public function me()
  {
    return response()->json([
      'ok' => true,
      'user' => Auth::user()
    ]);
  }

  public function makeInvited()
  {

    $permitted_chars1 = '0123456789abcdefghijklmnopqrstuvwxyz';
    $nrorandom =  substr(str_shuffle($permitted_chars1), 0, 4); //guardamos los caracteres aleatorios

    $animal = Animal::all()->random(); // con este metodo traigo un registro random
    $nomAnimal = $animal->animalName;

    $this->newInvited = new User();
    $this->newInvited->AdminUserCode = Uuid::uuid();
    $this->newInvited->NameUsuario = $nomAnimal . $nrorandom;
    $this->newInvited->password = bcrypt('12345678');
    $this->newInvited->isInvited = '1';
    $this->newInvited->save();


    //creamos un token que nos servira para la union de los usuarios
    $token = $this->newInvited->CreateToken('authToken')->accessToken;


    return response()->json([
      'ok'  => true,
      'user' => $this->newInvited,
      'token' => $token
    ]);
  }
}
