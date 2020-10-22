<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class CategoriaPersona extends Model
{
    protected $table = 'categoria_persona';
    protected $primaryKey = 'idcategoria_persona';
    public $timestamps = false;
    protected $fillable = [
        'idcategoria_persona',
        'nombre'
    ];
    protected $guarded = [
    ];//aca los que no queremos que se agreguen al modelo

    public static function index(\Illuminate\Http\Request $request, string $query)
    {
        return DB::table('categoria_persona')->where('nombre', 'LIKE', '%' . $query . '%')
            ->orderBy('nombre', 'asc')
            ->paginate(10);
    }

    public static function store(Http\Requests\CategoriaPersonaFormRequest $request)
    {
        $categoria = new self;
        $categoria->nombre = $request->get('nombre');
        $categoria->save();
    }

    public static function actualizar(Http\Requests\CategoriaPersonaFormRequest $request, $id)
    {
        $categoria = self::findOrFail($id);
        $categoria->nombre = $request->get('nombre');
        $categoria->update();
    }

    public static function desactivar($id)
    {
        $categoria = self::findOrFail($id);
        $categoria->condicion = '0';
        $categoria->update();
    }
}
