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
    public function __construct()
    {
        $this->middleware('auth');

    }

    public function index(Request $request)
    {
        if ($request) {
            $query = trim($request->get('searchText'));
            return view('compras.proveedor.index', ["personas" => Persona::indexProveedores('Proveedor',$query), "searchText" => $query]);
        }
    }

    public function create()
    {
        return view("compras.proveedor.create");

    }

    public function store(PersonaFormRequest $request)
    {
        Persona::saveProveedor($request);
        return Redirect::to('compras/proveedor');
    }

    public function show($id)
    {
        return view("compras.proveedor.show", ["persona" => Persona::findOrFail($id)]); //llama a la vista show pero envia la categoria definida para que la muestre y solo muestra esa con findOrShow
    }

    public function edit($id)
    {
        return view("compras.proveedor.edit", ["persona" => Persona::findOrFail($id)]);
    }

    public function update(PersonaFormRequest $request, $id)
    {
        Persona::actualizarProveedor($request, $id);
        return Redirect::to('compras/proveedor');
    }

    public function destroy($id)
    {
        Persona::desactivar($id);
        return Redirect::to('compras/proveedor');
    }
}
