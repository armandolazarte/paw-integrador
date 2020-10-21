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
            $table->string('descripcion')->nullable();
            $table->tinyInteger('condicion')->nullable();
        });

        Schema::create('categoria_persona', function (Blueprint $table) {
            $table->increments('idcategoria_persona');
            $table->string('nombre')->nullable();
        });

        Schema::create('persona',function(Blueprint $table){
            $table->increments('idpersona');
            $table->string('tipo_persona');
            $table->string('nombre');
            $table->string('tipo_documento')->nullable();
            $table->string('num_documento')->nullable();
            $table->string('direccion')->nullable();
            $table->string('telefono')->nullable();
            $table->string('email')->nullable();
            $table->integer('idcategoria_persona')->unsigned()->nullable();
        });
        Schema::table('persona', function($table){
            $table->foreign('idcategoria_persona')->references('idcategoria_persona')->on('categoria_persona');
        });

        Schema::create('articulo', function (Blueprint $table) {
            $table->increments('idarticulo');
            $table->integer('idcategoria')->unsigned();
            $table->string('codigo')->nullable();
            $table->string('nombre');
            $table->integer('stock')->nullable();
            $table->string('descripcion')->nullable();
            $table->string('imagen')->nullable();
            $table->string('estado')->nullable();
            $table->integer('minStock')->nullable();
        });
        Schema::table('articulo', function($table){
            $table->foreign('idcategoria')->references('idcategoria')->on('categoria');
        });

        Schema::create('venta', function (Blueprint $table) {
            $table->increments('idventa');
            $table->integer('idcliente')->unsigned();
            $table->string('tipo_comprobante')->nullable();
            $table->string('serie_comprobante')->nullable();
            $table->string('num_comprobante')->nullable();
            $table->dateTime('fecha_hora')->nullable();
            $table->decimal('total_venta',11,2)->nullable();
            $table->decimal('impuesto',4,2)->nullable();
            $table->string('estado')->nullable();
        });

        Schema::table('venta', function($table){
            $table->foreign('idcliente')->references('idpersona')->on('persona');
        });

        Schema::create('detalle_venta', function (Blueprint $table) {
            $table->increments('iddetalle_venta');
            $table->integer('idventa')->unsigned();
            $table->integer('idarticulo')->unsigned();
            $table->integer('cantidad')->nullable();
            $table->decimal('precio_compra',4,2)->nullable();
            $table->decimal('descuento',4,2)->nullable();
        });

        Schema::table('detalle_venta',function($table){
            $table->foreign('idventa')->references('idventa')->on('venta');
            $table->foreign('idarticulo')->references('idarticulo')->on('articulo');
        });



        Schema::create('ingreso', function (Blueprint $table) {
            $table->increments('idingreso');
            $table->integer('idproveedor')->unsigned();
            $table->string('tipo_comprobante');
            $table->string('serie_comprobante')->nullable();
            $table->string('num_comprobante')->nullable();
            $table->dateTime('fecha_hora')->nullable();
            $table->decimal('impuesto',4,2)->nullable();
            $table->string('estado')->nullable();
        });

        Schema::table('ingreso', function($table){
            $table->foreign('idproveedor')->references('idpersona')->on('persona');
        });

        Schema::create('detalle_ingreso', function (Blueprint $table) {
            $table->increments('iddetalle_ingreso');
            $table->integer('idingreso')->unsigned();
            $table->integer('idarticulo')->unsigned();
            $table->integer('cantidad')->nullable();
            $table->decimal('precio_compra',4,2)->nullable();
            $table->decimal('precio_venta',4,2)->nullable();
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
