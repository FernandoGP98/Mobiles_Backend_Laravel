<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    protected $except = [
        '/getPrueba',
        '/registrarPrueba',
        '/UsuarioGetByCorreo',
        '/UsuarioRegistrar',
        '/RestaurantesGetAllPublicados',
        '/RestaurantesRegistro',
        '/ImagenRegistro',
        '/ImagenGetByRestauranteId',
        '/VideoRegistro',
        '/VideoGetRestauranteId',
        '/ComentarioRegistro',
        '/ComentarioGetByRestauranteId',
        '/ComentarioGetByUsuarioId'

    ];
}
