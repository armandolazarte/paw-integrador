<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Tables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categoria', function (Blueprint $table) {
            $table->increments('idcategoria');
            $table->string('nombre');
            $table->string('descripcion');
            $table->tinyInteger('condicion');
        });

        Schema::create('categoria_persona', function (Blueprint $table) {
            $table->increments('idcategoria_persona');
            $table->string('nombre');
        });

        Schema::create('persona',function(Blueprint $table){
            $table->increments('idpersona');
            $table->string('tipo_persona');
            $table->string('nombre');
            $table->string('tipo_documento');
            $table->string('num_documento');
            $table->string('direccion');
            $table->string('telefono');
            $table->string('email');
            $table->integer('idcategoria_persona')->unsigned();
        });
        Schema::table('persona', function($table){
            $table->foreign('idcategoria_persona')->references('idcategoria_persona')->on('categoria_persona');
        });

        Schema::create('articulo', function (Blueprint $table) {
            $table->increments('idarticulo');
            $table->integer('idcategoria')->unsigned();
            $table->string('codigo');
            $table->string('nombre');
            $table->integer('stock');
            $table->string('descripcion');
            $table->string('imagen');
            $table->string('estado');
            $table->integer('minStock');
            $table->tinyInteger('condicion');
        });
        Schema::table('articulo', function($table){
            $table->foreign('idcategoria')->references('idcategoria')->on('categoria');
        });

        Schema::create('venta', function (Blueprint $table) {
            $table->increments('idventa');
            $table->integer('idcliente')->unsigned();
            $table->string('tipo_comprobante');
            $table->string('serie_comprobante');
            $table->string('num_comprobante');
            $table->dateTime('fecha_hora');
            $table->decimal('total_venta',11,2);
            $table->decimal('impuesto',4,2);
            $table->string('estado');
        });

        Schema::table('venta', function($table){
            $table->foreign('idcliente')->references('idpersona')->on('persona');
        });

        Schema::create('detalle_venta', function (Blueprint $table) {
            $table->increments('iddetalle_venta');
            $table->integer('idventa')->unsigned();
            $table->integer('idarticulo')->unsigned();
            $table->integer('cantidad');
            $table->decimal('precio_compra',4,2);
            $table->integer('mano_obra');
            $table->decimal('descuento',4,2);
        });

        Schema::table('detalle_venta',function($table){
            $table->foreign('idventa')->references('idventa')->on('venta');
            $table->foreign('idarticulo')->references('idarticulo')->on('articulo');
        });



        Schema::create('ingreso', function (Blueprint $table) {
            $table->increments('idingreso');
            $table->integer('idproveedor')->unsigned();
            $table->string('tipo_comprobante');
            $table->string('serie_comprobante');
            $table->string('num_comprobante');
            $table->dateTime('fecha_hora');
            $table->decimal('impuesto',4,2);
            $table->string('estado');
        });

        Schema::table('ingreso', function($table){
            $table->foreign('idproveedor')->references('idpersona')->on('persona');
        });

        Schema::create('detalle_ingreso', function (Blueprint $table) {
            $table->increments('iddetalle_ingreso');
            $table->integer('idingreso')->unsigned();
            $table->integer('idarticulo')->unsigned();
            $table->integer('cantidad');
            $table->decimal('precio_compra',4,2);
            $table->decimal('precio_venta',4,2);
        });

        Schema::table('detalle_ingreso',function($table){
            $table->foreign('idingreso')->references('idingreso')->on('ingreso');
            $table->foreign('idarticulo')->references('idarticulo')->on('articulo');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('categoria');
        Schema::dropIfExists('categoria_persona');
        Schema::dropIfExists('persona');
        Schema::dropIfExists('articulo');
        Schema::dropIfExists('ingreso');
        Schema::dropIfExists('venta');
        Schema::dropIfExists('detalle_venta');
        Schema::dropIfExists('detalle_ingreso');
    }
}
