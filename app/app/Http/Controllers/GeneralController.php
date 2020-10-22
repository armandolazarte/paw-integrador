<?php

namespace App\Http\Controllers;

use App\GeneralAdmin;
use Illuminate\Http\Request;

class GeneralController extends Controller
{
    public static function getLogo()
    {
        $path = public_path();
        return $path . "/logo.png";
    }

    public function search($table, $description)
    {
        return response()->json(['articulos' => GeneralAdmin::search($table, $description)]);
    }


}
