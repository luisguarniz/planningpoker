<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kindphrase extends Model
{
    use HasFactory;

        //relacion de uno a muchos
  public function phrases(){
    return $this->HasMany('App\Models\Phrase');
}
}
