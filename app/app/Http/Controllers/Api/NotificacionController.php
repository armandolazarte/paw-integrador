<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\NotificacionAdmin;


class NotificacionController extends Controller
{
    protected $admin;

    public function __construct()
    {
        $this->admin = new NotificacionAdmin;
    }

    public function read(Request $request) : JsonResponse
    {
        $idarticulo = $request->get('idarticulo');
        $flag = $this->admin->read($idarticulo);
        if ($flag == true) {
            return response()->json(['mensaje' => 'Notificación Leída', 'flag' => true]);
        }
    }

    public function getAll()
    {
        return response()->json(['notificaciones' => $this->admin->getAll()]);
    }

    public function readAll(){

        $this->admin->readAll();
        return response()->json(['status' => true]);

    }
}
