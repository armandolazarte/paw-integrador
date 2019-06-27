<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GeneralController extends Controller
{
    public static function getLogo(){
        $path=public_path();
        return $path."/logo.png";
    }
}
