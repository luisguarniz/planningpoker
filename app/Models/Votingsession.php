<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Votingsession extends Model
{
    use HasFactory;

  //relacion de uno a muchos
  public function votes(){
      return $this->HasMany('App\Models\Vote');
  }

    //relacion de uno a muchos (inversa)
    public function room(){
        return $this->belongsTo('App\Models\Room');
    }
}
