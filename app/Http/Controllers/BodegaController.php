<?php

namespace App\Http\Controllers;

use App\DetalleOrdenCompra;
use App\DetCompra;
use App\Familia;
use App\Observation;
use App\OrdenCompra;
use App\Product;
use App\RelProvProduct;
use App\Solicitudes;
use Illuminate\Http\Request;
use function Sodium\crypto_box_publickey_from_secretkey;


class BodegaController extends Controller
{
    public function productos(Request $request, $id){
        if($request -> ajax()){
            $prod = Product::productos($id);
            return response()->json($prod);
        }

    }
    public function proveedor(Request $request, $id)
    {
        if($request -> ajax()){
            $prov = RelProvProduct::listaProveedores($id);
            return response()->json($prov);
        }
    }

    public function ordencompra(Request $request)
    {
        if($request->ajax()){
            $array = json_decode($request->getContent(), true);
            $array = $array['o_compra'];

            foreach ($array as $key => $row) {
                $count[$key] = [$row['Proveedor'], $row['Cuenta'], $row['Solicitante']];
            }
            array_multisort($count, SORT_ASC, $array);
            $proveedor = '';
            $cuenta ='';
            $soli ='';
            $data2 = [];
            foreach ($array as $value) {
                if(($value['Proveedor'] != $proveedor) || ($value['Cuenta'] != $cuenta) || ($value['Solicitante'] != $soli)){
                    $id_oc = OrdenCompra::create([
                        'proveedor' => $value['Proveedor'],
                        'solicitante'=>$value['Solicitante'],
                        'cuenta' => $value['Cuenta'],
                    ])->id;
                    $data2[] = [
                            'oc' => $id_oc,
                            'proveedor' => $value['Proveedor'],
                    ];
                }
                $proveedor = $value['Proveedor'];
                $cuenta = $value['Cuenta'];
                $soli = $value['Solicitante'];
                DetCompra::create([
                    'oc_id' => $id_oc,
                    'producto' => $value['Producto'],
                    'unidad' => $value['Unidad'],
                    'valor_uni' => $value['Valor Uni.'],
                    'cantidad' => $value['Cantidad'],
                    'total' => $value['Total']
                ]);
            }
            return json_encode($data2);

        }
    }
    public function impresion($ocs){
        $ocs = (collect(json_decode($ocs)));
        return view('bodega.impresion_oc',compact('ocs'));
    }
    public function recibiroc(){
        return view('bodega.recibir_oc');
    }
    public function recibirocbusca(Request $request,$id)
    {
        if($request->ajax()){
            return response()->json( OrdenCompra::ordenCompra($id));
        }
    }
    public function recibirocdetalle(Request $request,$id)
    {
        if($request->ajax()){
            return response()->json(DetCompra::detCompra($id));
        }
    }
    public function recibir_post(Request $request){
        if($request->ajax()){
            return OrdenCompra::cierraOrdenCompra(json_decode($request->getContent(),true));
        }
    }
    public function recibirdetalle_post(Request $request){
        if($request->ajax()){
            $array = json_decode($request->getContent(), true);
            $array = $array['det_o_compra'];

            foreach ($array as $value) {
                DetCompra::cierraDetOrdenCompra($value['Id'],$value['Cantidad Modif'],$value['Observaciones']);
                Product::aunentaInventario($value['Producto'],$value['Cantidad Modif']);
            }
            return 'Ok';
        }
    }
    public function observaciones(Request $request){
        if($request->ajax()){
            return Observation::obs();

        }
    }
    public function solicitudes_pendientes(){
        $solicitudes =Solicitudes::where('estado','=','1')->get();
        return view('bodega.solicitudes_pendientes',compact('solicitudes'));
    }
    public function solicitudes_detalle($id){
        return view('bodega.csu_solicitud',compact('id'));
    }
    public function inventario(){
        $inventario = Product::all()->where('estado','=','1');

        return view('bodega.muestra_inventario',compact('inventario'));
    }
    public function inventario_modifica(){
        $familias=Familia::all();

        return view('bodega.modifica_inventario',compact('familias'));
    }




}
