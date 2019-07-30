<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class Product extends Model
{

    public static function productos($id){
        return Product::where('familia_id','=',$id)->get();
    }
    public static function prov_prod(){
        return DB::select('CALL lista_proveedores');
    }
    public static function aunentaInventario($producto,$cantidad){
        $campos = Product::where('producto','=',$producto)->get();
        $valor =$campos[0]->cantidad + $cantidad;
        Product::where('producto','=',$producto)->update(['cantidad'=>$valor]);
    }
}
