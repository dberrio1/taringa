<?php

namespace App\Http\Controllers;

use App\Cuenta;
use App\Divisiones;
use App\Familia;
use App\Product;
use App\Provider;


class LoginUserController extends Controller
{
    public function admin()
    {
        $prov = Provider::muestaProveedor();
        return view('admin.addProveedores',compact('prov'));
    }
    public function bodega()
    {
        $familias=Familia::all();
        $sol=Divisiones::all()->where('id','!=','1');
        $cc=Cuenta::all();

        return view('bodega.cuerpo_bodega',compact('familias','cc','sol'));
    }
    public function ocmasiva()
    {
        $cc=Cuenta::all();
        $prod = Product::prov_prod();
        $sol=Divisiones::all()->where('id','!=','1');

        return view('bodega.ordenCompraMasiva',compact('cc', 'prod','sol'));
    }





}
