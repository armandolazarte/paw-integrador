<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests\UsuarioFormRequest;
use DB;

class UsuarioController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        if ($request) {
            $query = trim($request->get('searchText'));
            return view('seguridad.usuario.index', ["usuarios" => User::index($query), "searchText" => $query]);
        }
    }

    public function create()
    {
        return view("seguridad.usuario.create");
    }

    public function store(UsuarioFormRequest $request)
    {
        User::guardar($request);
        return Redirect::to('seguridad/usuario');
    }

    public function edit($id)
    {
        return view("seguridad.usuario.edit", ["usuario" => User::findOrFail($id), "roles"=> User::getRoles()]);
    }

    public function update(UsuarioFormRequest $request, $id)
    {
        User::actualizar($request,$id);
        return Redirect::to('seguridad/usuario');
    }

    public function changeRole(Request $request)
    {
        User::changeRole($request);
        return $this->index($request);
    }

    public function destroy($id)
    {
        User::desactivar($id);
        return Redirect::to('seguridad/usuario');
    }


    public function show($id){
        print_r('entro aca');
    }

}
