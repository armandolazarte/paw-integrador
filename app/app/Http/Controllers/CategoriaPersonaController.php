<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\CategoriaPersona;
use Illuminate\Support\Facades\Redirect; //para realizar redirecciones
use App\Http\Requests\CategoriaPersonaFormRequest;
use DB; //espacio de nombres db de laravel

class CategoriaPersonaController extends Controller
{
    public function __construct(){
        $this->middleware('auth');

    }
    public function index(Request $request){
    	if ($request){ //si request existe voy a obteneer todos los registros categoria de la db
    		$query=trim($request->get('searchText'));	//determina cual es el texto de busqueda para filtrar todas las categorias. searchText porque va a existir un objeto en un formulario listado donde se van a ingresar las categorias que quiero mostrar
    		$categorias=DB::table('categoria_persona')->where('nombre','LIKE','%'.$query.'%')  //se usa la clase db para especificar la tabla donde se obtienen los registros y se agrega el where para indicar una condicion, aca se recibe el campo por el que se realiza el filtro, el comando like y el query que se va a buscar que esta en la variable query sin importar si esta al inicio o al final. 
    		->orderBy('nombre','asc')//ordena de manera descendente
    		->paginate(10); //pagina de a 7 registros
    		;
    		return view('categoria_persona.index',["categorias"=>$categorias,"searchText"=>$query]); //va a devolver la vista almacenada en almacen/cateogria  y se le pasan los parametros categorias (las listadas de la variable) y texto de busqueda que tenemos en la variable query
    	}
    }

    public function create(){
        //cuando se llame la url de create va a invocar al html que esta ubicado en almacen/categoria/create
    	return view("categoria_persona.create");

    }

    public function store(CategoriaPersonaFormRequest $request){ //almacenar el objeto del modelo categoria en la tabla categoria de la db
    	$categoria=new CategoriaPersona;
    	$categoria->nombre=$request->get('nombre');
    	//cuando se inicializa la categoria esta siempre en estado 1
    	$categoria->save(); //almacena el objeto categoria en la db
    	return Redirect::to('categoria_persona');//redirecciona al listado de todas las categorias
    }

    public function show($id){
    	return view("categoria_persona.show",["categoria"=>CategoriaPersona::findOrFail($id)]); //llama a la vista show pero envia la categoria definida para que la muestre y solo muestra esa con findOrShow
    }

    public function edit($id){
    	return view("categoria_persona.edit",["categoria"=>CategoriaPersona::findOrFail($id)]); 
    }

    public function update(CategoriaPersonaFormRequest $request, $id){ //almaceno la categoria modificada
    	$categoria=CategoriaPersona::findOrFail($id);
    	$categoria->nombre=$request->get('nombre');
    	$categoria->update(); //actualizo los datos de la categoria que recibe como parametro en el $id
    	return Redirect::to('categoria_persona');
    }

    public function destroy($id){
    	$categoria=Categoria::findOrFail($id);
    	$categoria->condicion='0';
    	$categoria->update();
    	return Redirect::to('almacen/categoria');
    }
}
