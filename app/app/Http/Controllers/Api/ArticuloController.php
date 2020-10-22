<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Articulo;
use DB;

class ArticuloController extends Controller
{

    public function search(Request $request){

        if ($request){ //si request existe voy a obteneer todos los registros categoria de la db
            
            $query = trim($request->get('query'));	//determina cual es el texto de busqueda para filtrar todas las categorias. searchText porque va a existir un objeto en un formulario listado donde se van a ingresar las categorias que quiero mostrar   
            $articulos = Articulo::getAll($query);

            return response()->json($articulos);

        } else {
            return null;
        }
    }

}
