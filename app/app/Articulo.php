<?php

namespace App;

use App\Http\Requests\ArticuloFormRequest;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;

class Articulo extends Model
{
    protected $table = 'articulo';
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $fillable = [
        'idcategoria',
        'codigo',
        'nombre',
        'stock',
        'descripcion',
        'imagen',
        'estado',
        'minStock',
        'precio_venta'
    ];
    protected $guarded = [
    ];//aca los que no queremos que se agreguen al modelo

    /**
     * Devuelvo el articulo mas vendido en un período de tiempo
     * @param $fechaDesde
     * @param $fechaHasta
     * @return mixed
     */
    public static function masVendido($fechaDesde, $fechaHasta)
    {

        return self::join('detalle_venta', 'detalle_venta.idarticulo', '=', 'articulo.id')
            ->join('venta', 'venta.idventa', '=', 'detalle_venta.idventa')
            ->select(
                DB::raw('articulo.descripcion'),
                DB::raw('articulo.nombre'),
                DB::raw('SUM(detalle_venta.cantidad) as cantidad')
            )
            ->where('venta.fecha_hora', '>=', $fechaDesde)
            ->where('venta.fecha_hora', '<=', $fechaHasta)
            ->groupBy('articulo.nombre', 'articulo.descripcion')
            ->orderBy('cantidad', 'desc')
            ->first();
    }

    public static function store(ArticuloFormRequest $request)
    {
        $articulo = new self;
        $articulo->idcategoria = strtoupper($request->get('idcategoria'));
        $articulo->codigo = strtoupper($request->get('codigo'));
        $articulo->nombre = strtoupper($request->get('nombre'));
        $articulo->descripcion = strtoupper($request->get('descripcion'));
        $articulo->estado = "Activo";
        $articulo->minStock = $request->get('minStock');
        $articulo->precio_venta = $request->get('precio_venta');
        if (Input::hasFile('imagen')) {
            $file = Input::file('imagen');
            $file->move(public_path() . '/imagenes/articulos/', $file->getClientOriginalName());
            $articulo->imagen = $file->getClientOriginalName();
        }

        $articulo->save(); //almacena el objeto categoria en la db
    }

    public static function getArticulo($id)
    {
        return DB::table('articulo as art')
            ->join('detalle_ingreso as di', 'art.id', '=', 'di.idarticulo')
            ->select('art.id', 'art.nombre', 'art.stock', 'art.precio_venta as precio_promedio')
            ->where('art.id', '=', $id)
            ->groupBy('art.id', 'art.nombre', 'art.stock')
            ->get();
    }

    public static function actualizar(ArticuloFormRequest $request, $id)
    {
        $articulo = self::findOrFail($id);
        $articulo->idcategoria = strtoupper($request->get('idcategoria'));
        $articulo->codigo = strtoupper($request->get('codigo'));
        $articulo->nombre = strtoupper($request->get('nombre'));
        $articulo->descripcion = strtoupper($request->get('descripcion'));
        $articulo->minStock = $request->get('minStock');
        $articulo->precio_venta = $request->get('precio_venta');
        if (Input::hasFile('imagen')) {
            $file = Input::file('imagen');
            $file->move(public_path() . '/imagenes/', $file->getClientOriginalName());
            $articulo->imagen = $file->getClientOriginalName();
        }
        $articulo->update(); //actualizo los datos de la categoria que recibe como parametro en el $id
    }

    public static function desactivar($id)
    {
        $articulo = self::findOrFail($id);
        $articulo->Estado = 'Inactivo';
        $articulo->update();
    }

    /**
     * Devuelvo el listado de articulos para un ingreso o egreso
     * @return mixed
     */
    public static function getArticulos()
    {
        return DB::table('articulo as art')
            ->join('categoria as c', 'art.idcategoria', '=', 'c.idcategoria')
            ->select(DB::raw('CONCAT(art.codigo,"|",c.nombre,"|",art.nombre) AS articulo'), 'art.id')
            ->where('art.estado', '=', 'Activo')
            ->get();
    }

    public static function getArticulosVenta()
    {
        return DB::table('articulo as art')
            ->join('detalle_ingreso as di', 'art.id', '=', 'di.idarticulo')
            ->join('categoria as c', 'art.idcategoria', '=', 'c.idcategoria')
            ->select(DB::raw('CONCAT(c.nombre," | ",art.nombre) AS articulo'), 'art.id', 'art.stock', 'art.precio_venta as precio_promedio')
            ->where('art.estado', '=', 'Activo')
            ->where('art.stock', '>', '0')
            ->groupBy('articulo', 'art.id', 'art.stock')
            ->get();
    }

    public static function getAll($queryString, $filter, $inStock)
    {

        return self::join('categoria as c', 'articulo.idcategoria', '=', 'c.idcategoria')
            ->when(! empty($queryString), function ($query) use ($queryString) {
                return $query->where('articulo.nombre', 'LIKE', '%' . $queryString . '%')
                ->orWhere('articulo.codigo', 'LIKE', '%' . $queryString . '%')
                ->where('articulo.stock', '>', '1');
            })
            ->when(! empty($filter), function ($query) use ($filter) {
                    return $query->where('c.idcategoria', '=', intval($filter));
                })
            
            ->where('articulo.estado', '=', 'Activo')
            ->orderBy('articulo.id', 'ASC')
            ->select('articulo.id', 'articulo.nombre', 'articulo.codigo', 'c.nombre as categoria',
                    'articulo.minStock', 'articulo.stock',  'articulo.precio_venta', 'articulo.imagen')
            ->paginate(10);

    }

    public static function index($query)
    {
        return self::getAll($query, false, false);
    }


}
