<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProdAlmacenes extends Model
{
    protected $fillable = [
        'almacen','producto','unidad', 'familia', 'cantidad'
    ];
    public static function inventario($a,$p,$u,$m){
        $producto = ProdAlmacenes::where('producto','=',$p)->first();

        if($producto === null){
            ProdAlmacenes::create([
                'almacen' => $a,
                'producto'=> $p,
                'unidad'=> $u,
                'familia'=> 'lacteos',
                'cantidad'=> $m
            ]);
        }else{
            $valor = ProdAlmacenes::select('cantidad')->where([['almacen', '=',$a],['producto', '=',$p]])->first();
            $monto = $valor->cantidad + $m;
            ProdAlmacenes::where([['almacen', '=',$a],['producto', '=',$p]])->update(['cantidad' => $monto  ]);
        }
    }

}
