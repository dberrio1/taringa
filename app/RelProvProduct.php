<?php

namespace App;
use DB;

use Illuminate\Database\Eloquent\Model;


class RelProvProduct extends Model
{

    public static function listaProveedores($id_producto){
        $data = DB::table('providers')
            -> join('rel_prov_products' ,'providers.id' ,'=','prov_id')
            -> join('products'          ,'prod_id'      ,'=','products.id')
            -> join('units'             ,'units.id'   ,'=','products.unidad_id')
            -> where('products.id',$id_producto)->get();

        return $data;
    }
}
