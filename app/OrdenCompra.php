<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrdenCompra extends Model
{
    protected $fillable = [
        'proveedor', 'solicitante','cuenta'
    ];

    public static function ordenCompra($id){
        return OrdenCompra::where('id','=',$id)->get();
    }
    public static function cierraOrdenCompra($id){

        OrdenCompra::where('id','=',$id['ordencompra'])->update(['estado'=>'0','factura'=>$id['factura']]);

    }
}
