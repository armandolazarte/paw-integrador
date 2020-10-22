<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Categoria;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests\CategoriaFormRequest;
use DB;

class CategoriaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');

    }

    public function index(Request $request)
    {
        if ($request) {
            $query = trim($request->get('searchText'));
            return view('almacen.categoria.index', ["categorias" => Categoria::getIndex($request, $query), "searchText" => $query]);
        }
    }

    public function create()
    {
        return view("almacen.categoria.create");

    }

    public function store(CategoriaFormRequest $request)
    {
        Categoria::create($request);
        return Redirect::to('almacen/categoria');
    }

    public function show($id)
    {
        return view("almacen.categoria.show", ["categoria" => Categoria::findOrFail($id)]);
    }

    public function edit($id)
    {
        return view("almacen.categoria.edit", ["categoria" => Categoria::findOrFail($id)]);
    }

    public function update(CategoriaFormRequest $request, $id)
    {
        Categoria::actualizar($request, $id);
        return Redirect::to('almacen/categoria');
    }

    public function destroy($id)
    {
        Categoria::desactivar($id);
        return Redirect::to('almacen/categoria');
    }

}
