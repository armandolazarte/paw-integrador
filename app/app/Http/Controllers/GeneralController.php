<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GeneralController extends Controller
{
    public static function getLogo(){
        $path=public_path();
        return $path."/logo.png";
    }

    public function search($table,$description){
        $articles=DB::table($table)
            ->where('nombre','LIKE','%'.$description.'%')
            ->orderBy('nombre')
            ->get();
        return response()->json(['articulos'=>$articles]);
    }


}
