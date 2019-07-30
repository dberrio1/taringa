<?php

namespace App\Http\Controllers;

use App\Cuenta;
use App\DetallesSolicitudes;
use App\DetCompra;
use App\Divisiones;
use App\Familia;
use App\OrdenCompra;
use App\ProdAlmacenes;
use App\Product;
use App\Solicitudes;
use function foo\func;
use Illuminate\Http\Request;

class AlmacenController extends Controller
{
    public function productos(Request $request, $id){
        if($request -> ajax()){
            $prod = Product::productos($id);
            return response()->json($prod);
        }

    }
    public function almacen($id){
        $almacen = Divisiones::where('id','=',$id)->first();
        $nombre_corto =$almacen->nombre_corto;
        $familias=Familia::all();

        $cc=Cuenta::all();

        return view('almacen.almacen_bodega',compact('id','nombre_corto','familias','cc'));

    }
    public function almacen_recibir($id){
        $almacen = Divisiones::where('id','=',$id)->first();
        $nombre_corto =$almacen->nombre_corto;

        return view('almacen.recibir_solicitud',compact('nombre_corto'));
    }
    public function almacen_masivo($id){
        $almacen = Divisiones::where('id','=',$id)->first();
        $nombre_corto =$almacen->nombre_corto;
        $familias=Familia::all();
        $prod = Product::prov_prod();

        $cc=Cuenta::all();

        return view('almacen.almacen_bodega_masiva',compact('id','nombre_corto','familias','cc','prod'));

    }
    public function solicitudBodega(Request $request)
    {
        if($request->ajax()){
            $array = json_decode($request->getContent(), true);

            $array = $array['solicitud'];

            foreach ($array as $key => $row) {
                $count[$key] = [$row['Cuenta'], $row['Solicitante']];
            }
            array_multisort($count, SORT_ASC, $array);
            $cuenta ='';
            $soli ='';

            foreach ($array as $value) {
                if(($value['Cuenta'] != $cuenta) || ($value['Solicitante'] != $soli)){
                    $id_oc = Solicitudes::create([
                        'solicitante'=>$value['Solicitante'],
                        'cuenta' => $value['Cuenta'],
                    ])->id;
                }
                $cuenta = $value['Cuenta'];
                $soli = $value['Solicitante'];

                DetallesSolicitudes::create([
                    'sol_id' => $id_oc,
                    'producto' => $value['Producto'],
                    'unidad' => $value['Unidad'],
                    'cantidad' => $value['Cantidad']
                ]);
            }

            return 'ok';

        }
    }
    public function csu_solicitud(Request $request,$id)
    {
        if($request->ajax()){
            return response()->json(Solicitudes::solicitud($id));
        }
    }
    public function csu_detalle_solicitud(Request $request,$id)
    {
        if($request->ajax()){
            return response()->json(DetallesSolicitudes::detSolicitud($id));
        }
    }
    public function recibir_post(Request $request){
        if($request->ajax()){
            return Solicitudes::cierraSolicitud(json_decode($request->getContent(),true));
        }
    }
    public function recibirdetalle_post(Request $request){
        if($request->ajax()){
            $array = json_decode($request->getContent(), true);
            $array = $array['solicitud_det'];

            foreach ($array as $value) {
                DetallesSolicitudes::cierraDetSolicitud($value['Id'],$value['Cantidad Modif'],$value['Observaciones']);
                ProdAlmacenes::inventario($value['almacen'],$value['Producto'],$value['Unidad'],$value['Cantidad Modif']);
            }
            return 'Ok';
        }
    }
}
