<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class GeneralAdmin extends Model
{
    //
    public static function search($table, $description)
    {
        return DB::table($table)
            ->where('nombre','LIKE','%'.$description.'%')
            ->orderBy('nombre')
            ->get();
    }
}
