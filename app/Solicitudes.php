<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Solicitudes extends Model
{
    protected $fillable = [
        'solicitante','cuenta'
    ];
    public static function solicitud($id){
        return Solicitudes::where('id','=',$id)->get();
    }
    public static function cierraSolicitud($id){

        Solicitudes::where('id','=',$id['solicitud'])->update(['estado'=>'0',]);

    }
}
