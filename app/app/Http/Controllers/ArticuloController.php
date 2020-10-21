<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Input;
use App\Http\Requests\ArticuloFormRequest;
use App\Articulo;
use DB;

class ArticuloController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }
    public function index(Request $request){
    	if ($request){ //si request existe voy a obteneer todos los registros categoria de la db
				$query = trim($request->get('searchText'));	//determina cual es el texto de busqueda para filtrar todas las categorias. searchText porque va a existir un objeto en un formulario listado donde se van a ingresar las categorias que quiero mostrar
				
				$articulos = Articulo::getAll($query);

        if ($request->has('json')) {
          return $articulos;
        } else {
          return view('almacen.articulo.index',["articulos"=>$articulos,"searchText"=>$query]); //va a devolver la vista almacenada en almacen/cateogria  y se le pasan los parametros categorias (las listadas de la variable) y texto de busqueda que tenemos en la variable query
        }
    	}
    }

    public function create(){
        //cuando se llame la url de create va a invocar al html que esta ubicado en almacen/categoria/create
        $categorias=DB::table('categoria')->where('condicion','=','1')->get();
        //llama solo los articulos con categorias activas
    	return view("almacen.articulo.create",["categorias"=>$categorias]);

    }

    public function store(ArticuloFormRequest $request){ //almacenar el objeto del modelo articulo en la tabla articulo de la db
    	$articulo=new Articulo;
    	$articulo->idcategoria=strtoupper($request->get('idcategoria'));
    	$articulo->codigo=strtoupper($request->get('codigo'));
    	$articulo->nombre=strtoupper($request->get('nombre'));
    	$articulo->stock=0;
    	$articulo->descripcion=strtoupper($request->get('descripcion'));
    	$articulo->estado="Activo";
      $articulo->minStock=$request->get('minStock');
    	if(Input::hasFile('imagen')){
    		$file=Input::file('imagen');
    		$file->move(public_path().'/imagenes/articulos/',$file->getClientOriginalName());
    		$articulo->imagen=$file->getClientOriginalName();
    	}

    	$articulo->save(); //almacena el objeto categoria en la db
    	return Redirect::to('almacen/articulo');//redirecciona al listado de todas las categorias
    }

//    public function show($id){
//    	return view("almacen.articulo.show",["articulo"=>Articulo::findOrFail($id)]); //llama a la vista show pero envia el articulo definida para que la muestre y solo muestra esa con findOrShow
//    }

    public function show($id){
        $articulo = DB::table('articulo as art')
            ->join('detalle_ingreso as di','art.idarticulo','=','di.idarticulo')
            ->select('art.idarticulo','art.nombre','art.stock',DB::raw('max(di.precio_venta) as precio_promedio'))
            ->where('art.idarticulo','=',$id)
            ->groupBy('art.idarticulo','art.nombre','art.stock')
            ->get()
        ;
        return $articulo;
    }



    public function edit($id){
    	$articulo=Articulo::findOrFail($id);
    	$categorias=DB::table('categoria')->where('condicion','=','1')->get(); //qiero todas las categorias que esten activas
    	return view("almacen.articulo.edit",["articulo"=>$articulo,"categorias"=>$categorias]);
    }

    public function update(ArticuloFormRequest $request, $id){ //almaceno el articulo modificada
    	$articulo=Articulo::findOrFail($id);
      $articulo->idcategoria=strtoupper($request->get('idcategoria'));
    	$articulo->codigo=strtoupper($request->get('codigo'));
    	$articulo->nombre=strtoupper($request->get('nombre'));
    	$articulo->stock=strtoupper($request->get('stock'));
    	$articulo->descripcion=strtoupper($request->get('descripcion'));
        $articulo->minStock=$request->get('minStock');
    	if(Input::hasFile('imagen')){
    		$file=Input::file('imagen');
    		$file->move(public_path().'/imagenes/',$file->getClientOriginalName());
    		$articulo->imagen=$file->getClientOriginalName();
    	}
    	$articulo->update(); //actualizo los datos de la categoria que recibe como parametro en el $id
    	return Redirect::to('almacen/articulo');
    }

    public function destroy($id){
    	$articulo=Articulo::findOrFail($id);
    	$articulo->Estado='Inactivo';
    	$articulo->update();
    	return Redirect::to('almacen/articulo');
    }

    public function masVendido(){
        $producto=Articulo::masVendido();
    }

}
