<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RutasController extends Controller
{
    public function getUsuarioPorId(){
        return '{"resultado":"Correcto", "th":'.$usuario->toJson().'}';
    }
}
