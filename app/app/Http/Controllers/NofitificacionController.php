<?php

namespace App\Http\Controllers;

use App\NotificacionAdmin;
use Illuminate\Http\Request;

class NofitificacionController extends Controller
{
    protected $admin;

    public function __construct()
    {
        $this->admin = new NotificacionAdmin;
    }

    public function read($idarticulo)
    {
        $flag = $this->admin->read($idarticulo);
        if ($flag == true) {
            return response()->json(['mensaje' => 'Notificación Leída', 'flag' => true]);
        }
    }

    public function getAll()
    {
        return response()->json(['notificaciones' => $this->admin->getAll()]);
    }
}
