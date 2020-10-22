<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\NotificacionAdmin;


class NotificacionController extends Controller
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
