<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\CategoriaPersona;
use Illuminate\Support\Facades\Redirect;

//para realizar redirecciones
use App\Http\Requests\CategoriaPersonaFormRequest;
use DB;

//espacio de nombres db de laravel

class CategoriaPersonaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');

    }

    public function index(Request $request)
    {
        if ($request) {
            $query = trim($request->get('searchText'));
            return view('categoria_persona.index', ["categorias" => CategoriaPersona::index($request, $query), "searchText" => $query]);
        }
    }

    public function create()
    {
        return view("categoria_persona.create");

    }

    public function store(CategoriaPersonaFormRequest $request)
    {
        CategoriaPersona::store($request);
        return Redirect::to('categoria_persona');
    }

    public function show($id)
    {
        return view("categoria_persona.show", ["categoria" => CategoriaPersona::findOrFail($id)]); //llama a la vista show pero envia la categoria definida para que la muestre y solo muestra esa con findOrShow
    }

    public function edit($id)
    {
        return view("categoria_persona.edit", ["categoria" => CategoriaPersona::findOrFail($id)]);
    }

    public function update(CategoriaPersonaFormRequest $request, $id)
    {
        CategoriaPersona::actualizar($request, $id);
        return Redirect::to('categoria_persona');
    }

    public function destroy($id)
    {
        CategoriaPersona::desactivar($id);
        return Redirect::to('almacen/categoria');
    }
}
