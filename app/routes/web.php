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
Route::get('/', function () {
    return view('auth/login');
});

Route::resource('almacen/categoria', 'CategoriaController');

Route::resource('almacen/articulo', 'ArticuloController');
Route::resource('ventas/cliente', 'ClienteController');
Route::resource('compras/proveedor', 'ProveedorController');
Route::resource('compras/ingreso', 'IngresoController');
Route::resource('ventas/venta', 'VentaController');
Route::resource('seguridad/usuario', 'UsuarioController');
Route::resource('categoria_persona', 'CategoriaPersonaController');
Route::get('ventas/cliente/{id}/create', 'ClienteController@edit');
Route::get('seguridad/usuario/edit/{id}', 'UsuarioController@edit');
Route::get('ventas/venta/imprimir/{id}', 'VentaController@imprimir');
Route::get('logout', 'Auth\LoginController@logout');
Auth::routes();
Route::get('/home', 'HomeController@index');
Route::get('/{slug?}', 'HomeController@index');
Route::patch('/seguridad/usuarios/changeRole','UsuarioController@changeRole')->name('usuarios.changeRole');

Route::get('/seguridad/usuarios/desactivar/{id}','UsuarioController@destroy')->name('usuarios.desactivar');
//Route::get('almacen/articulo/eliminar/{id}','ArticuloController@changeState');
