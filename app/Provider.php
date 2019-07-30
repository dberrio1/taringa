<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Provider extends Model
{
    protected $fillable = [
        'rut','nombre','contacto','correo','fono','estado'
    ];
    public static function addProveedor($e){
          Provider::create([
            'rut' => $e['rut'],
            'nombre' => $e['nombre'],
            'contacto' => $e['contacto'],
            'correo' => $e['correo'],
            'fono' => $e['fono'],
            'estado'=> '1'
        ]);
    }
    public static function muestaProveedor(){
        return Provider::all();
    }
}
