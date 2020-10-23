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
        // Trigger que aumenta el stock en el ingreso
        DB::unprepared('CREATE TRIGGER `tr_updStockIngreso` AFTER INSERT ON `detalle_ingreso` FOR EACH ROW BEGIN
    	    UPDATE articulo SET stock=stock+NEW.cantidad
            WHERE articulo.id=NEW.idarticulo;
        END');

        // Trigger que reduce el stock en el egreso
        DB::unprepared('CREATE TRIGGER `tr_updStockVenta` AFTER INSERT ON `detalle_venta` FOR EACH ROW BEGIN
    	    UPDATE articulo SET stock = stock - NEW.cantidad
            where articulo.id = NEW.idarticulo;
        END');

        // Trigger de notificaciones
        DB::unprepared("
        CREATE TRIGGER `tr_notif_updStock` AFTER UPDATE ON `articulo` FOR EACH ROW BEGIN

            IF (NEW.stock <> OLD.stock) AND (NEW.stock < NEW.minStock)
            THEN  
                INSERT INTO `notificaciones` (msj) VALUES(CONCAT('Stock bajo: ', NEW.nombre)) ;
            END IF;
        
        END");

        DB::unprepared("
        CREATE TRIGGER `tr_notif_aftVenta` AFTER INSERT ON `venta` FOR EACH ROW BEGIN

            INSERT INTO `notificaciones` (msj) VALUES(CONCAT('Nueva venta por: $', NEW.total_venta)) ;
        
        END");

        DB::unprepared("
        CREATE TRIGGER `tr_notif_aftIngreso` AFTER INSERT ON `ingreso` FOR EACH ROW BEGIN

            INSERT INTO `notificaciones` (msj) VALUES(CONCAT('Nueva ingreso por: $', NEW.total_compra)) ;
        
        END");
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
        DB::unprepared('DROP TRIGGER `tr_notif_updStock`');
        DB::unprepared('DROP TRIGGER `tr_notif_aftVenta`');
        
    }
}
