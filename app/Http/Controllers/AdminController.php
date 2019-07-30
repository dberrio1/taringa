<?php

namespace App\Http\Controllers;

use App\Provider;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function formProveedor(){
        $prov = Provider::muestaProveedor();
        return view('admin.addProveedores',compact('prov'));
    }

    public function addProveedor(Request $request){
        if($request->ajax()){
            Provider::addProveedor(json_decode($request->getContent(),true));
            return 'Ok';
        }
    }
}
