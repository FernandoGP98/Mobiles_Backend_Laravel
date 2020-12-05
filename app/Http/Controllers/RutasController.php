<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\Usuario;
use App\Models\Restaurante;
use App\Models\Video;
use App\Models\Comentario;

class RutasController extends Controller
{
    public function getPrueba(){
        $prueba = DB::select('select * from pruebas');
        $response["prueba"]=$prueba;
        $response["success"]=1;
        return response()->json($response);
        //return '{"resultado":"Correcto", "th":'.$usuario->toJson().'}';
    }

    public function registrarPrueba(Request $request){
        $res = DB::insert('insert into pruebas (texto) values (?)', [$request->texto]);
        if($res>0){
            $response["success"]=1;
            return response()->json($response);
        }else{
            $response["success"]=0;
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

    public  function UsuarioRegistrar(Request $request){
        /*$res = DB::insert('insert into usuarios (email, password, nombre, rol_id) values (?,?,?,?)',
        [$request->correo, $request->password, $request->nombre, $request->id_Rol]);*/

        $user = new Usuario;
        $user->nombre = $request->nombre;
        $user->email=$request->correo;
        $user->password=$request->password;
        $user->rol_id=$request->rol_id;
        if($user->save()){
            $response["usuario"]=Usuario::find($user->id);
            $response["success"]=1;
            return response()->json($response);
        }else{
            $response["success"]=0;
            return response()->json($response);
        }
    }

    public  function RestaurantesGetAllPublicados(){
        $res = Restaurante::select('id','nombre','descripcion', 'calificacion', 'img1', 'img2', 'img3')->where('estado', 0)->get();
        if($res->count()>0){
            $response["restaurantes"]=$res;
            $response["success"]=1;
        }else{
            $response["restaurantes"]=$res;
            $response["success"]=0;
        }
        return response()->json($response);
    }

    public  function RestaurantesRegistro(Request $request){
        $res = DB::insert('insert into restaurantes (nombre, descripcion, locacion,
        lunes, martes, miercoles, jueves, viernes, sabado, domingo,latitud, longitud,
        usuario_id) values (?,?,?,?,?,?,?,?,?,?,?,?,?)',
        [$request->nombre, $request->descripcion, $request->locacion, $request->lunes,
        $request->martes, $request->miercoles, $request->jueves, $request->viernes,
        $request->sabado, $request->domingo, $request->latitud, $request->longitud,
        $request->usuario]);

        /*$restaurante = new Restaurante;
        $restaurante->nombre = $request->nombre;
        $restaurante->descripcion = $request->descripcion;
        $restaurante->locacion = $request->locacion;
        $restaurante->usuario_id = $request->usuario_id;
        $restaurante->estado = $request->estado;*/


        if($res>0){
            $response["success"]=1;
            return response()->json($response);
        }else{
            $response["success"]=0;
            return response()->json($response);
        }
    }

    public function RestauranteRegistroPrueba(Request $request){
        $restaurante = new Restaurante;
        $restaurante->nombre = $request->nombre;
        $restaurante->descripcion = $request->descripcion;
        $restaurante->usuario_id = $request->usuario_id;
        $restaurante->locacion = "";
        $restaurante->estado = $request->estado;
        $restaurante->img1=$request->img1;
        $restaurante->img2=$request->img2;
        $restaurante->img3=$request->img3;
        if($restaurante->save()){
            $response["restaurante"]=Restaurante::find($restaurante->id);
            $response["success"]=1;
            return response()->json($response);
        }else{
            $response["success"]=0;
            return response()->json($response);
        }
    }

    public function VideoRegistro(Request $request){
        $res = DB::insert('insert into videos (URL, restaurante_id) values(?,?)',
        [$request->url, $request->restaurante_id]);
        if($res>0){
            $response["success"]=1;
            return response()->json($response);
        }else{
            $response["success"]=0;
            return response()->json($response);
        }
    }

    public function VideoGetRestauranteId(Request $request){
        $res = Video::select('id','URL')->where('restaurante_id', $request->restaurante_id)->get();
        if($res->count()>0){
            $response["videos"]=$res;
            $response["success"]=1;
        }else{
            $response["videos"]=$res;
            $response["success"]=0;
        }
        return response()->json($response);
    }

    public function ComentarioRegistro(Request $request){
        $res = DB::insert('insert into comentarios (texto, calificacion, restaurante_id, usuario_id) values(?,?,?,?)',
        [$request->texto, $request->calificacion, $request->restaurante_id, $request->usuario_id]);
        if($res>0){
            $response["success"]=1;
            return response()->json($response);
        }else{
            $response["success"]=0;
            return response()->json($response);
        }
    }

    public function ComentarioGetByRestauranteId(Request $request){
        $res = Comentario::select('id','texto', 'calificacion', 'usuario_id')
        ->where('restaurante_id', $request->restaurante_id)->get();
        if($res->count()>0){
            $response["comentarios"]=$res;
            $response["success"]=1;
        }else{
            $response["comentarios"]=$res;
            $response["success"]=0;
        }
        return response()->json($response);
    }

    public function ComentarioGetByUsuarioId(Request $request){
        $res = Comentario::select('id','texto', 'calificacion', 'restaurante_id')
        ->where('usuario_id', $request->user_id)->get();
        if($res->count()>0){
            $response["comentarios"]=$res;
            $response["success"]=1;
        }else{
            $response["comentarios"]=$res;
            $response["success"]=0;
        }
        return response()->json($response);
    }
}
