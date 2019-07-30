<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DetallesSolicitudes extends Model
{
    protected $fillable = [
        'sol_id','producto','unidad','cantidad'
    ];
    public static function detSolicitud($id){
        return DetallesSolicitudes::where('sol_id','=',$id)->get();
    }
    public static function cierraDetSolicitud($id,$e,$o){
        DetallesSolicitudes::where('id','=',$id)->update(['entregado'=>$e,'observaciones'=>$o]);
    }
}
