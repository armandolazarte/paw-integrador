<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
use mysql_xdevapi\Exception;

class NotificacionAdmin extends Model
{
    public function getAll()
    {
        return Notificacion::where('visto',0)->get();
    }

    public function read($id)
    {
        try {
            DB::beginTransaction();
            $notificacion = Notificacion::find($id);
            $notificacion->visto = 1;
            $notificacion->update();
            DB::commit();
            return true;
        }catch (Exception $e){
            DB::rollback();
            throw $e;
        }
    }

    public function readAll(){
        DB::table('notificaciones')->where('visto', '=', 0)->update(array('visto' => 1));
    }
}
