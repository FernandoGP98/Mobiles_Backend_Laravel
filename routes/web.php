<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RutasController;
use App\Http\Controllers\Usuario;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/*
PARA VER REFLEJADOS LOS POST USEN https://reqbin.com/
SI SOLO PONEN LA URL LES SALDRA ESTE ERROR
"The GET method is not supported for this route. Supported methods: POST."
NO SE PREOCUPEN SI JALA SOLO NO SE PUEDE ACCEDER CON SOLO PONER LA URL
POR CIERTO, JALA EN MODO LOCAL
"php artisan serve"<- En la consola


CADA QUE AGREGUEN UNA NUEVA RUTA '/ejemplo' Y SEA POR MEDIO DE POST
DEBEN AGREGARLA TAMBIEN AL ARCHIVO 'app\Http\Middleware\VerifyCsrfToken.php'
AHI YA ESTAN LAS DE PRUEBA PARA QUE VEAN COMO SE AGREGAN
LOS GET NO REQUIEREN ESTE PASO.
*/

Route::post('/getPrueba', 'RutasController@getPrueba');
Route::post('/registrarPrueba','RutasController@registrarPrueba');

Route::post('/UsuarioGetByCorreo', 'RutasController@UsuarioGetByCorreo');
Route::post('/UsuarioRegistrar', 'RutasController@UsuarioRegistrar');
Route::post('/UsuarioUpdateNombre', 'RutasController@UsuarioUpdateNombre');
Route::post('/UsuarioUpdateFoto', 'RutasController@UsuarioUpdateFoto');

Route::post('/RestaurantesGetAllPublicados', 'RutasController@RestaurantesGetAllPublicados');
Route::post('/RestaurantesRegistro', 'RutasController@RestaurantesRegistro');
Route::post('/RestauranteRegistroPrueba', 'RutasController@RestauranteRegistroPrueba');

Route::post('/FavoritoRegistrar', 'RutasController@FavoritoRegistrar');
Route::post('/FavoritoGetByUsuarioId', 'RutasController@FavoritoGetByUsuarioId');

Route::post('/ComentarioRegistro', 'RutasController@ComentarioRegistro');
Route::post('/ComentarioGetByRestauranteId', 'RutasController@ComentarioGetByRestauranteId');
Route::post('/ComentarioGetByUsuarioId', 'RutasController@ComentarioGetByUsuarioId');

//Route::post('/login', 'Usuario');
