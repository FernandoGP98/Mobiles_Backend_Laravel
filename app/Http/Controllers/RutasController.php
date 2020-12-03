<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RutasController extends Controller
{
    public function getPrueba(){
        $prueba = DB::select('select * from prueba');
        $response["prueba"]=$prueba;
        $response["succes"]=1;
        return response()->json($response);
        //return '{"resultado":"Correcto", "th":'.$usuario->toJson().'}';
    }

    public function registrarPrueba(Request $request){
        $res = DB::insert('insert into prueba (texto) values (?)', [$request->texto]);
        if($res>0){
            $response["succes"]=1;
            return response()->json($response);
        }else{
            $response["succes"]=0;
            return response()->json($response);
        }
    }

    public function UsuarioGetByCorreo(Request $request){
        $usuario = DB::select('select id, nombre, email, password, foto, rol_id from usuario where email = ?', [$request->correo]);
        if(!is_null($usuario)){
            $response["usuario"]=$usuario->toJson();
            $response["success"]=1;
        }else{
            $response["usuario"]=null;
            $response["success"]=0;
        }
        return response()->json($response);
        //return '{"resultado":"Correcto", "th":'.$usuario->toJson().'}';
    }
}
