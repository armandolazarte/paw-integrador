<?php

namespace App\Http\Controllers;

use App\Articulo;
use App\Persona;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests\IngresoFormRequest;
use App\Ingreso;
use DB;
use Response;

class IngresoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        if ($request) {
            $query = trim($request->get('searchText'));
            return view('compras.ingreso.index', ["ingresos" => Ingreso::index($query), "searchText" => $query]);
        }
    }

    public function create()
    {
        return view("compras.ingreso.create", ["personas" => Persona::getProveedores(), "articulos" => Articulo::getArticulos()]);
    }

    public function store(IngresoFormRequest $request)
    {
        Ingreso::store($request);
        return Redirect::to('compras/ingreso');
    }

    public function show($id)
    {
        $respuesta = Ingreso::showIngreso($id);
        return view("compras.ingreso.show", ["ingreso" => $respuesta['ingreso'], "detalles" => $respuesta['detalles']]);
    }

    public function destroy($id)
    {
        Ingreso::desactivar($id);
        return Redirect::to('compras/ingreso');
    }
}
