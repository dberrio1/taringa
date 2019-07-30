<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DetCompra extends Model
{
    protected $fillable = [
        'oc_id','producto','unidad','valor_uni','cantidad','entregado','total'
    ];

    public static function detCompra($id){
        return DetCompra::where('oc_id','=',$id)->get();
    }
    public static function cierraDetOrdenCompra($id,$e,$o){

        DetCompra::where('id','=',$id)->update(['entregado'=>$e,'observaciones'=>$o]);
    }
}
