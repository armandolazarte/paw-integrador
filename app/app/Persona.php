<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Persona extends Model
{
    protected $table = 'persona';
    protected $primaryKey = 'idpersona';
    public $timestamps = false;
    protected $fillable = [
        'tipo_persona',
        'nombre',
        'tipo_documento',
        'num_documento',
        'direccion',
        'telefono',
        'email',
        'idcategoria_persona'
    ];
    protected $guarded = [
    ];//aca los que no queremos que se agreguen al modelo

    public static function indexClientes(\Illuminate\Http\Request $request, string $query)
    {
        return DB::table('persona as p')
            ->select('p.idpersona', 'p.tipo_persona', 'p.nombre', 'p.tipo_documento', 'p.num_documento', 'p.direccion', 'p.telefono', 'p.email', 'cp.nombre as categoria_persona')
            ->join('categoria_persona as cp', 'p.idcategoria_persona', '=', 'cp.idcategoria_persona')
            ->where('p.nombre', 'LIKE', '%' . $query . '%')
            ->where('tipo_persona', '=', 'Cliente')
            ->orwhere('num_documento', 'LIKE', '%' . $query . '%')
            ->where('tipo_persona', '=', 'Cliente')
            ->orderBy('idpersona', 'asc')
            ->paginate(10);
    }

    public static function saveCliente(Http\Requests\PersonaFormRequest $request)
    {
        $persona = new self;
        $persona->tipo_persona = 'Cliente';
        $persona->nombre = $request->get('nombre');
        $persona->tipo_documento = $request->get('tipo_documento');
        $persona->num_documento = $request->get('num_documento');
        $persona->direccion = $request->get('direccion');
        $persona->telefono = $request->get('telefono');
        $persona->email = $request->get('email');
        $persona->idcategoria_persona = $request->get('idcategoria_persona');
        $persona->save();
    }

    public static function actualizarCliente(Http\Requests\PersonaFormRequest $request, $id)
    {
        $persona = self::findOrFail($id);
        $persona->nombre = $request->get('nombre');
        $persona->tipo_documento = $request->get('tipo_documento');
        $persona->num_documento = $request->get('num_documento');
        $persona->direccion = $request->get('direccion');
        $persona->telefono = $request->get('telefono');
        $persona->email = $request->get('email');
        $persona->idcategoria_persona = $request->get('idcategoria_persona');
        $persona->update();
    }

    public static function desactivar($id)
    {
        $persona = self::findOrFail($id);
        $persona->tipo_persona = 'Inactivo';
        $persona->update();
    }

    public static function getProveedores()
    {
        return DB::table('persona')->where('tipo_persona', '=', 'Proveedor')->get();
    }

    public static function indexProveedores(string $query)
    {
        return DB::table('persona')
            ->where('nombre', 'LIKE', '%' . $query . '%')
            ->where('tipo_persona', '=', 'Proveedor')
            ->orwhere('num_documento', 'LIKE', '%' . $query . '%')
            ->where('tipo_persona', '=', 'Proveedor')
            ->orderBy('idpersona', 'desc')
            ->paginate(7);
    }

    public static function saveProveedor(Http\Requests\PersonaFormRequest $request)
    {
        $persona = new self;
        $persona->tipo_persona = 'Proveedor';
        $persona->nombre = $request->get('nombre');
        $persona->tipo_documento = $request->get('tipo_documento');
        $persona->num_documento = $request->get('num_documento');
        $persona->direccion = $request->get('direccion');
        $persona->telefono = $request->get('telefono');
        $persona->email = $request->get('email');
        //$persona->idcategoria='Proveedor';
        $persona->save();
    }

    public static function actualizarProveedor(Http\Requests\PersonaFormRequest $request, $id)
    {
        $persona = self::findOrFail($id);
        $persona->nombre = $request->get('nombre');
        $persona->tipo_documento = $request->get('tipo_documento');
        $persona->num_documento = $request->get('num_documento');
        $persona->direccion = $request->get('direccion');
        $persona->telefono = $request->get('telefono');
        $persona->email = $request->get('email');
        $persona->update();
    }

    public static function getClientes()
    {
        return DB::table('persona')->where('tipo_persona', '=', 'Cliente')->get();
    }
}
