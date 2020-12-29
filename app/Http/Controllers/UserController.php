<?php

namespace App\Http\Controllers;

use App\Models\Animal;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{

    //creamos los datos aleatoriamente. En un escenario normal estariamos recibiendo datos en el metodo makeUser con $request
    // y estariamos asignando a su respectivo modelo.(asi como aca)
    public function makeUser(){
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

    //creamos un token que nos servira para la union de los usuarios
    //$token = $newUser->CreateToken('authToken')->accesToken;
    $token = $newUser->createToken('authToken')->accessToken;
    $response['NameUsuario']= $newUser->NameUsuario;
    $response ['AdminUserCode'] = $newUser->AdminUserCode ;
    $response ['$token'] = $token;
        //devolvemos el codigo de usuario por que sera incertado en un campo al crear el room de la otra tabla
        return $response;
    }

}
