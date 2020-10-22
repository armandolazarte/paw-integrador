<?php

namespace App;

use App\Http\Requests\CategoriaFormRequest;
use App\Http\Requests\Request;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Categoria extends Model
{
    protected $table = 'categoria';
    protected $primaryKey = 'idcategoria';
    public $timestamps = false;
    protected $fillable = [
        'nombre',
        'descripcion',
        'condicion'
    ];
    protected $guarded = [
    ];//aca los que no queremos que se agreguen al modelo

    public static function getCategorias()
    {
        return DB::table('categoria')->where('condicion', '=', '1')->get();
    }

    public static function getIndex($query)
    {
        return self::where('nombre', 'LIKE', '%' . $query . '%')
            ->where('condicion', '=', '1')
            ->orderBy('idcategoria', 'desc')
            ->paginate(3);
    }

    public static function create(CategoriaFormRequest $request)
    {
        $categoria = new self();
        $categoria->nombre = $request->get('nombre');
        $categoria->descripcion = $request->get('descripcion');
        $categoria->condicion = '1';
        $categoria->save();
    }

    public static function actualizar(CategoriaFormRequest $request, $id)
    {
        $categoria = self::findOrFail($id);
        $categoria->nombre = $request->get('nombre');
        $categoria->descripcion = $request->get('descripcion');
        $categoria->update();
    }

    public static function desactivar($id)
    {
        $categoria = self::findOrFail($id);
        $categoria->condicion = '0';
        $categoria->update();
    }
}
