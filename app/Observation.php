<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Observation extends Model
{
    public static function obs(){

        return Observation::where('cuenta','=','bodega')->get();
    }
}
