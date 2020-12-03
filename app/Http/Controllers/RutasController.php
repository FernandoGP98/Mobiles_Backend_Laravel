<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\Usuario;

class RutasController extends Controller
{
    public function getPrueba(){
        $prueba = DB::select('select * from pruebas');
        $response["prueba"]=$prueba;
        $response["succes"]=1;
        return response()->json($response);
        //return '{"resultado":"Correcto", "th":'.$usuario->toJson().'}';
    }

    public function registrarPrueba(Request $request){
        $res = DB::insert('insert into pruebas (texto) values (?)', [$request->texto]);
        if($res>0){
            $response["succes"]=1;
            return response()->json($response);
        }else{
            $response["succes"]=0;
            return response()->json($response);
        }
    }

    public function UsuarioGetByCorreo(Request $request){
        $usuario = Usuario::select('id', 'nombre', 'email', 'password', 'foto', 'rol_id')
        ->where( 'email', $request->correo)->where('password', $request->password)->get();

        if($usuario->count()>0){
            $response["usuario"]=$usuario;
            $response["success"]=1;
        }else{
            $response["usuario"]=$usuario;
            $response["success"]=0;
        }
        return response()->json($response);
        //return '{"resultado":"Correcto", "th":'.$usuario->toJson().'}';
    }
}
