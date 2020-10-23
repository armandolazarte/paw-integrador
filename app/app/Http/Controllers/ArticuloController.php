<?php

namespace App\Http\Controllers;

use App\Categoria;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Input;
use App\Http\Requests\ArticuloFormRequest;
use App\Articulo;
use DB;

class ArticuloController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        if ($request) { //si request existe voy a obteneer todos los registros categoria de la db
            $query = trim($request->get('searchText'));
            $articulos = Articulo::index($query);

            if ($request->has('json')) {
                return $articulos;
            } else {
                return view('almacen.articulo.index', 
                            ["articulos" => $articulos, 
                            "categorias" => Categoria::getCategorias(),
                            "searchText" => $query]);
            }
        }
    }

    public function create()
    {
        return view("almacen.articulo.create", ["categorias" => Categoria::getCategorias()]);
    }

    public function store(ArticuloFormRequest $request)
    {
        Articulo::store($request);
        return Redirect::to('almacen/articulo');//redirecciona al listado de todas las categorias
    }

    public function show($id)
    {
        return view("almacen.articulo.show", ["articulo" => Articulo::find($id)]); //llama a la vista show pero envia la categoria definida para que la muestre y solo muestra esa con findOrShow
    }


    public function edit($id)
    {
        $articulo = Articulo::findOrFail($id);
        return view("almacen.articulo.edit", ["articulo" => $articulo, "categorias" => Categoria::getCategorias()]);
    }

    public function update(ArticuloFormRequest $request, $id)
    { //almaceno el articulo modificada
        Articulo::actualizar($request, $id);
        return Redirect::to('almacen/articulo');
    }

    public function destroy($id)
    {

        Articulo::desactivar($id);
        return Redirect::to('almacen/articulo');
    }

    public function masVendido()
    {
        $producto = Articulo::masVendido();
    }

}
