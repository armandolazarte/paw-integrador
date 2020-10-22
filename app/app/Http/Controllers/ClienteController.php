<?php

namespace App\Http\Controllers;

use App\Venta;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Persona;
use App\CategoriaPersona;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests\PersonaFormRequest;
use DB;

class ClienteController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');

    }

    public function index(Request $request)
    {
        if ($request) {
            $query = trim($request->get('searchText'));
            return view('ventas.cliente.index', ["personas" => Persona::indexClientes($request, $query), "searchText" => $query]);
        }
    }

    public function create()
    {
        return view("ventas.cliente.create", ["categorias" => CategoriaPersona::all()]);
    }

    public function store(PersonaFormRequest $request)
    {
        Persona::saveCliente($request);
        return Redirect::to('ventas/cliente');
    }

    public function show($id)
    {
        return view("ventas.cliente.show", ["cliente" => Persona::findOrFail($id), "ventas" => Venta::ventaPorCliente($id)]); //llama a la vista show pero envia la categoria definida para que la muestre y solo muestra esa con findOrShow
    }

    public function edit($id)
    {
        return view("ventas.cliente.edit", ["persona" => Persona::findOrFail($id), "categorias" => CategoriaPersona::all()]);
    }

    public function update(PersonaFormRequest $request, $id)
    {
        Persona::actualizarCliente($request, $id);
        return Redirect::to('ventas/cliente');
    }

    public function destroy($id)
    {
        Persona::desactivar($id);
        return Redirect::to('ventas/cliente');
    }
}
