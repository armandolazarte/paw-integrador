<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Persona;
use App\CategoriaPersona;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests\PersonaFormRequest;
use DB;

class ClienteController extends Controller
{
    public function __construct(){
        $this->middleware('auth');

    }
    public function index(Request $request){
    	if ($request){ //si request existe voy a obteneer todos los registros categoria de la db
    		$query=trim($request->get('searchText'));	//determina cual es el texto de busqueda para filtrar todas las categorias. searchText porque va a existir un objeto en un formulario listado donde se van a ingresar las categorias que quiero mostrar
    		$personas=DB::table('persona as p')
            ->select('p.idpersona','p.tipo_persona','p.nombre','p.tipo_documento','p.num_documento','p.direccion','p.telefono','p.email','cp.nombre as categoria_persona')
            ->join('categoria_persona as cp','p.idcategoria_persona','=','cp.idcategoria_persona')
            ->where('p.nombre','LIKE','%'.$query.'%')
    		->where ('tipo_persona','=','Cliente')//donde la condicion sea igual a 1, las categorias activas
    		->orwhere('num_documento','LIKE','%'.$query.'%')
			  ->where ('tipo_persona','=','Cliente')
    		->orderBy('idpersona','asc')//ordena de manera descendente

    		->paginate(10); //pagina de a 7 registros
    		;
    		return view('ventas.cliente.index',["personas"=>$personas,"searchText"=>$query]); //va a devolver la vista almacenada en almacen/cateogria  y se le pasan los parametros categorias (las listadas de la variable) y texto de busqueda que tenemos en la variable query
    	}
    }

    public function create(){
        //cuando se llame la url de create va a invocar al html que esta ubicado en almacen/categoria/create
      $categorias=DB::table('categoria_persona')
      ->orderBy('idcategoria_persona','asc')
      ->get();
      return view("ventas.cliente.create",["categorias"=>$categorias]);
    }

    public function store(PersonaFormRequest $request){ //almacenar el objeto del modelo categoria en la tabla categoria de la db
    	$persona=new Persona;
    	$persona->tipo_persona='Cliente';
    	$persona->nombre=$request->get('nombre');
    	$persona->tipo_documento=$request->get('tipo_documento'); //cuando se inicializa la categoria esta siempre en estado 1
    	$persona->num_documento=$request->get('num_documento');
    	$persona->direccion=$request->get('direccion');
    	$persona->telefono=$request->get('telefono');
    	$persona->email=$request->get('email');
      $persona->idcategoria_persona=$request->get('idcategoria_persona');
    	$persona->save(); //almacena el objeto categoria en la db
    	return Redirect::to('ventas/cliente');//redirecciona al listado de todas las categorias
    }

    public function show($id){
      $ventas=DB::table('venta as v')
       ->join('persona as p','v.idcliente','=','p.idpersona')
       ->join('detalle_venta as dv','v.idventa','=','dv.idventa')
       ->select('v.idventa','v.fecha_hora','p.nombre','v.tipo_comprobante','v.serie_comprobante','v.num_comprobante','v.impuesto','v.estado','v.total_venta')
       ->where('v.idcliente','=',$id)
       ->orderBy('v.idventa','desc')
       ->groupBy('v.idventa','v.fecha_hora','p.nombre','v.tipo_comprobante','v.serie_comprobante','v.num_comprobante','v.impuesto','v.estado','v.total_venta')
       ->paginate(7);
    	return view("ventas.cliente.show",["cliente"=>Persona::findOrFail($id),"ventas"=>$ventas]); //llama a la vista show pero envia la categoria definida para que la muestre y solo muestra esa con findOrShow
    }

    public function edit($id){
        $categorias=DB::table('categoria_persona')
            ->orderBy('idcategoria_persona','asc')
            ->get();
    	return view("ventas.cliente.edit",["persona"=>Persona::findOrFail($id),"categorias"=>$categorias]);
    }

    public function update(PersonaFormRequest $request, $id){ //almaceno la categoria modificada
    	$persona=Persona::findOrFail($id);
    	$persona->nombre=$request->get('nombre');
    	$persona->tipo_documento=$request->get('tipo_documento');
    	$persona->num_documento=$request->get('num_documento');
    	$persona->direccion=$request->get('direccion');
    	$persona->telefono=$request->get('telefono');
    	$persona->email=$request->get('email');
      $persona->idcategoria_persona=$request->get('idcategoria_persona');
    	$persona->update(); //actualizo los datos de la categoria que recibe como parametro en el $id
    	return Redirect::to('ventas/cliente');
    }

    public function destroy($id){
    	$persona=Persona::findOrFail($id);
    	$persona->tipo_persona='Inactivo';
    	$persona->update();
    	return Redirect::to('ventas/cliente');
    }
}
