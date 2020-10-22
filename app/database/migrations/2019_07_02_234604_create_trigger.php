<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTrigger extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared('CREATE TRIGGER `tr_updStockIngreso` AFTER INSERT ON `detalle_ingreso` FOR EACH ROW BEGIN
    	    UPDATE articulo SET stock=stock+NEW.cantidad
            WHERE articulo.id=NEW.idarticulo;
        END');
        DB::unprepared('CREATE TRIGGER `tr_updStockVenta` AFTER INSERT ON `detalle_venta` FOR EACH ROW BEGIN
    	    UPDATE articulo SET stock = stock - NEW.cantidad
            where articulo.id = NEW.idarticulo;
        END');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::unprepared('DROP TRIGGER `tr_updStockIngreso`');
        DB::unprepared('DROP TRIGGER `tr_updStockVenta`');
    }
}
