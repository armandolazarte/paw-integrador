<?php

namespace App;

use App\Http\Requests\ArticuloFormRequest;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;

class Articulo extends Model
{
    protected $table = 'articulo';
    protected $primaryKey = 'idarticulo';
    public $timestamps = false;
    protected $fillable = [
        'idcategoria',
        'codigo',
        'nombre',
        'stock',
        'descripcion',
        'imagen',
        'estado',
        'minStock'
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

        return self::join('detalle_venta', 'detalle_venta.idarticulo', '=', 'articulo.idarticulo')
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
        $articulo->stock = 0;
        $articulo->descripcion = strtoupper($request->get('descripcion'));
        $articulo->estado = "Activo";
        $articulo->minStock = $request->get('minStock');
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
            ->join('detalle_ingreso as di', 'art.idarticulo', '=', 'di.idarticulo')
            ->select('art.idarticulo', 'art.nombre', 'art.stock', DB::raw('max(di.precio_venta) as precio_promedio'))
            ->where('art.idarticulo', '=', $id)
            ->groupBy('art.idarticulo', 'art.nombre', 'art.stock')
            ->get();
    }

    public static function actualizar(ArticuloFormRequest $request, $id)
    {
        $articulo = self::findOrFail($id);
        $articulo->idcategoria = strtoupper($request->get('idcategoria'));
        $articulo->codigo = strtoupper($request->get('codigo'));
        $articulo->nombre = strtoupper($request->get('nombre'));
        $articulo->stock = strtoupper($request->get('stock'));
        $articulo->descripcion = strtoupper($request->get('descripcion'));
        $articulo->minStock = $request->get('minStock');
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
            ->select(DB::raw('CONCAT(art.codigo,"|",c.nombre,"|",art.nombre) AS articulo'), 'art.idarticulo')
            ->where('art.estado', '=', 'Activo')
            ->get();
    }

    public static function getArticulosVenta()
    {
        return DB::table('articulo as art')
            ->join('detalle_ingreso as di', 'art.idarticulo', '=', 'di.idarticulo')
            ->join('categoria as c', 'art.idcategoria', '=', 'c.idcategoria')
            ->select(DB::raw('CONCAT(c.nombre," | ",art.nombre) AS articulo'), 'art.idarticulo', 'art.stock', DB::raw('max(di.precio_venta) as precio_promedio'))
            ->where('art.estado', '=', 'Activo')
            ->where('art.stock', '>', '0')
            ->groupBy('articulo', 'art.idarticulo', 'art.stock')
            ->get();
    }

    public static function getAll($query)
    {
        return self::join('categoria as c', 'articulo.idcategoria', '=', 'c.idcategoria')
            ->select('articulo.minStock', 'articulo.idarticulo', 'articulo.nombre', 'articulo.codigo', 'articulo.stock', 'c.nombre as categoria', 'articulo.descripcion', 'articulo.imagen', 'articulo.estado')
            ->where('articulo.nombre', 'LIKE', '%' . $query . '%')
            ->orWhere('articulo.codigo', 'LIKE', '%' . $query . '%')
            ->where('articulo.estado', '=', 'Activo')
            ->orderBy('articulo.idarticulo', 'desc')
            ->paginate(10);

    }

    public function index(Request $request)
    {
        $query = trim($request->get('searchText'));    //determina cual es el texto de busqueda para filtrar todas las categorias. searchText porque va a existir un objeto en un formulario listado donde se van a ingresar las categorias que quiero mostrar
        return self::getAll($query);
    }


}
