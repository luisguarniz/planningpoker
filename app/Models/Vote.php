<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vote extends Model
{
    use HasFactory;

    //relacion de uno a muchos(inversa)
    public function votingsession(){
        return $this->belongsTo('App\Models\Votingsession');
    }
}
