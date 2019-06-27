<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Persona;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests\PersonaFormRequest;
use DB;

class ProveedorController extends Controller
{
    public function __construct(){
        $this->middleware('auth');

    }
    public function index(Request $request){
    	if ($request){ //si request existe voy a obteneer todos los registros categoria de la db
    		$query=trim($request->get('searchText'));	//determina cual es el texto de busqueda para filtrar todas las categorias. searchText porque va a existir un objeto en un formulario listado donde se van a ingresar las categorias que quiero mostrar
    		$personas=DB::table('persona')
            ->where('nombre','LIKE','%'.$query.'%')
    		->where ('tipo_persona','=','Proveedor')//donde la condicion sea igual a 1, las categorias activas
    		->orwhere('num_documento','LIKE','%'.$query.'%')
			->where ('tipo_persona','=','Proveedor')
    		->orderBy('idpersona','desc')//ordena de manera descendente

    		->paginate(7); //pagina de a 7 registros
    		;
    		return view('compras.proveedor.index',["personas"=>$personas,"searchText"=>$query]); //va a devolver la vista almacenada en almacen/cateogria  y se le pasan los parametros categorias (las listadas de la variable) y texto de busqueda que tenemos en la variable query
    	}
    }

    public function create(){
        //cuando se llame la url de create va a invocar al html que esta ubicado en almacen/categoria/create
    	return view("compras.proveedor.create");

    }

    public function store(PersonaFormRequest $request){ //almacenar el objeto del modelo categoria en la tabla categoria de la db
    	$persona=new Persona;
    	$persona->tipo_persona='Proveedor';
    	$persona->nombre=$request->get('nombre');
    	$persona->tipo_documento=$request->get('tipo_documento'); //cuando se inicializa la categoria esta siempre en estado 1
    	$persona->num_documento=$request->get('num_documento');
    	$persona->direccion=$request->get('direccion');
    	$persona->telefono=$request->get('telefono');
  		$persona->email=$request->get('email');
  		//$persona->idcategoria='Proveedor';
    	$persona->save(); //almacena el objeto categoria en la db
    	return Redirect::to('compras/proveedor');//redirecciona al listado de todas las categorias
    }

    public function show($id){
    	return view("compras.proveedor.show",["persona"=>Persona::findOrFail($id)]); //llama a la vista show pero envia la categoria definida para que la muestre y solo muestra esa con findOrShow
    }

    public function edit($id){
    	return view("compras.proveedor.edit",["persona"=>Persona::findOrFail($id)]);
    }

    public function update(PersonaFormRequest $request, $id){ //almaceno la categoria modificada
    	$persona=Persona::findOrFail($id);
    	$persona->nombre=$request->get('nombre');
    	$persona->tipo_documento=$request->get('tipo_documento');
    	$persona->num_documento=$request->get('num_documento');
    	$persona->direccion=$request->get('direccion');
    	$persona->telefono=$request->get('telefono');
    	$persona->email=$request->get('email');
    	$persona->update(); //actualizo los datos de la categoria que recibe como parametro en el $id
    	return Redirect::to('compras/proveedor');
    }

    public function destroy($id){
    	$persona=Persona::findOrFail($id);
    	$persona->tipo_persona='Inactivo';
    	$persona->update();
    	return Redirect::to('compras/proveedor');
    }
}
