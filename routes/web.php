<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
use Illuminate\Http\Request;
Route::get('/', function () {
    //return view('welcome');
    return view('auth.login');

});

//Route::get('/', 'HomeController@index');

Auth::routes();


Route::get('/home', 'HomeController@index')->name('home');

Route::get('/admin','LoginUserController@admin')->name('admin');



Route::get('/bodega','LoginUserController@bodega')->name('bodega');
Route::get('/almacen/{id}','AlmacenController@almacen')->name('bodega.almacen');
Route::get('/almacen/masivo/{id}','AlmacenController@almacen_masivo')->name('bodega.almacen_masiva');
Route::get('/almacen/recibir/{id}','AlmacenController@almacen_recibir')->name('bodega.almacen_recibir');

Route::get('/almacen/solicitud/{id}','AlmacenController@csu_solicitud')->name('bodega.solicitud');
Route::get('/almacen/solicitud/detalle/{id}','AlmacenController@csu_detalle_solicitud')->name('bodega.solicitud_detalle');
Route::post('/almacen/recibir','AlmacenController@recibir_post')->name('recibir_almacen.post');
Route::post('/almacen/recibir/detalle','AlmacenController@recibirdetalle_post')->name('recibir_almacen_detalle.post');


Route::post('/almacen','AlmacenController@solicitudBodega')->name('almacen.post');



Route::get('/bodega/ocmasiva','LoginUserController@ocmasiva')->name('ocmasiva');
Route::get('/bodega/imprimir/{oc}','BodegaController@impresion')->name('bodega.imprimir')->where('oc', '(.*)');
Route::get('/bodega/recibir','BodegaController@recibiroc')->name('bodega.recibir');
Route::get('/bodega/recibir/observaciones','BodegaController@observaciones')->name('recibir.observaciones');
Route::get('/bodega/recibir/{id}','BodegaController@recibirocbusca');
Route::get('/bodega/recibir/detalle/{id}','BodegaController@recibirocdetalle');
Route::get('/bodega/solicitudes/pendientes','BodegaController@solicitudes_pendientes')->name('bodega.sol_pendientes');
Route::get('/bodega/solicitudes/detalle/{id}','BodegaController@solicitudes_detalle')->name('bodega.sol_detalle');
Route::get('/bodega/inventario','BodegaController@inventario')->name('bodega.inventario');
Route::get('/bodega/inventario/modifica','BodegaController@inventario_modifica')->name('bodega.inventario_modifica');


Route::post('/bodega/recibir','BodegaController@recibir_post')->name('recibir.post');
Route::post('/bodega/recibir/detalle','BodegaController@recibirdetalle_post')->name('recibir.detalle.post');



Route::get('/bodega/{id}','BodegaController@productos');
Route::get('/bodega/proveedor/{id}','BodegaController@proveedor');
Route::post('/bodega','BodegaController@ordencompra')->name('bodega.post');

Route::post('/admin/proveedores', 'AdminController@addProveedor')->name('admin.proveedor');
Route::get('/admin/proveedores', 'AdminController@formProveedor')->name('admin.proveedor_form');





