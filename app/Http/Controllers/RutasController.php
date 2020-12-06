<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\Usuario;
use App\Models\Restaurante;
use App\Models\Video;
use App\Models\Comentario;
use App\Models\favorito;

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

    public function UsuarioUpdateNombre(Request $request){
        $usuario = Usuario::find($request->id);
        $usuario->nombre = $request->nombre;
        if($usuario->save()){
            $response["usuario"]=Usuario::find($usuario->id);
            $response["success"]=1;
            return response()->json($response);
        }else{
            $response["success"]=0;
            return response()->json($response);
        }
    }

    public function UsuarioUpdatePass(Request $request){
        $usuario = Usuario::find($request->id);
        $usuario->password = $request->password;
        if($usuario->save()){
            $response["usuario"]=Usuario::find($usuario->id);
            $response["success"]=1;
            return response()->json($response);
        }else{
            $response["success"]=0;
            return response()->json($response);
        }
    }

    public function UsuarioUpdateFoto(Request $request){
        $usuario = Usuario::find($request->id);
        $usuario->foto = $request->foto;
        if($usuario->save()){
            $response["usuario"]=Usuario::find($usuario->id);
            $response["success"]=1;
            return response()->json($response);
        }else{
            $response["success"]=0;
            return response()->json($response);
        }
    }

    public function UsuarioEliminar(Request $request){
        $usuario = Usuario::find($request->id);
        $comm = Comentario::where('usuario_id', $usuario->id)->get();
        if($comm->count()>0){
            for ($i=0; $i < $comm->count(); $i++) {
                $comm[$i]->delete();
            }
        }

        $fav = favorito::where('usuario_id', $usuario->id)->get();
        if($fav->count()>0){
            for ($i=0; $i < $fav->count(); $i++) {
                $fav[$i]->delete();
            }
        }

        $res = Restaurante::where('usuario_id', $usuario->id)->get();
        if($res->count()>0){
            for ($i=0; $i < $res->count(); $i++) {
                Comentario::where('restaurante_id',  $res[$i]->id)->delete();
                favorito::where('restaurante_id',  $res[$i]->id)->delete();
            }
            Restaurante::where('usuario_id', $usuario->id)->delete();
        }

        if($usuario->delete()){
            $response["success"]=1;
            return response()->json($response);
        }else{
            $response["success"]=0;
            return response()->json($response);
        }
    }

    public  function RestaurantesGetAllPublicados(){
        $res = Restaurante::select('id','nombre','descripcion', 'calificacion', 'latitud','longitud'
        ,'img1', 'img2', 'img3')
            ->where('estado', 2)->get();
        if($res->count()>0){
            $response["restaurantes"]=$res;
            $response["success"]=1;
        }else{
            $response["restaurantes"]=$res;
            $response["success"]=0;
        }
        return response()->json($response);
    }

    public function RestaurantesGetByUsuario(Request $request){
        $res = Restaurante::select('id','nombre','descripcion', 'calificacion', 'img1', 'img2', 'img3',
        'latitud','longitud')
        ->where('usuario_id', $request->id)->get();
        if($res->count()>0){
            $response["restaurantes"]=$res;
            $response["success"]=1;
        }else{
            $response["restaurantes"]=$res;
            $response["success"]=0;
        }
        return response()->json($response);
    }

    public function RestauranteUpdateById(Request $request){
        $res = Restaurante::find($request->id);
        $res->nombre = $request->nombre;
        $res->descripcion = $request->descripcion;
        $res->locacion = "";
        $res->latitud=$request->latitud;
        $res->longitud=$request->longitud;
        $res->img1 = $request->img1;
        $res->img2 = $request->img2;
        $res->img3 = $request->img3;
        if($res->save()){
            $response["usuario"]=Restaurante::find($res->id);
            $response["success"]=1;
            return response()->json($response);
        }else{
            $response["success"]=0;
            return response()->json($response);
        }
    }

    public function RestaurantesDeleteById(Request $request){
        if(Restaurante::where('id', $request->id)->delete()){
            $response["success"]=1;
        }else{
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
        $restaurante->latitud=$request->latitud;
        $restaurante->longitud = $request->longitud;
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

    public function FavoritoRegistrar(Request $request){

        $siHay = favorito::where('usuario_id', $request->usuario_id)
        ->where('restaurante_id', $request->restaurante_id)->get();
        if($siHay->isEmpty()){
            $fav = new favorito;
            $fav->restaurante_id= $request->restaurante_id;
            $fav->usuario_id= $request->usuario_id;
            $siHay=0;
            if($fav->save()){
                $response["success"]=1;
                $response["siHay"]=$siHay;
                return response()->json($response);
            }else{
                $response["success"]=0;
                $response["siHay"]=$siHay;
                return response()->json($response);
            }
        }else{
            $siHay[0]->delete();
            $siHay=1;
            $response["success"]=0;
            $response["siHay"]=$siHay;
            return response()->json($response);
        }




    }

    public function FavoritoGetByUsuarioId(Request $request){
        $fav = DB::table('favoritos')
        ->select('restaurantes.id','restaurantes.nombre','restaurantes.descripcion','restaurantes.calificacion',
        'restaurantes.img1', 'restaurantes.img2', 'restaurantes.img3', 'restaurantes.latitud', 'restaurantes.longitud')
         ->join('restaurantes', 'restaurantes.id', '=', 'favoritos.restaurante_id')
         ->join('usuarios', 'usuarios.id', '=', 'favoritos.usuario_id')
         ->where('usuarios.id', $request->usuario_id)->get();
        if($fav->count()>0){
            $response["favoritos"]=$fav;
            $response["success"]=1;

        }else{
            $response["favoritos"]=$fav;
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
