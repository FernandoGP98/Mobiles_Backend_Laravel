<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Restaurante extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('restaurantes', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('descripcion');
            $table->integer('calificacion')->nullable();
            $table->text('locacion');
            $table->boolean('estado');
            $table->time('lunes', 0)->nullable();
            $table->time('martes', 0)->nullable();
            $table->time('miercoles', 0)->nullable();
            $table->time('jueves', 0)->nullable();
            $table->time('viernes', 0)->nullable();
            $table->time('sabado', 0)->nullable();
            $table->time('domingo', 0)->nullable();
            $table->string('latitud')->nullable();
            $table->string('longitud')->nullable();

            $table->unsignedBigInteger('usuario_id');
            $table->foreign('usuario_id')->references('id')->on('usuarios');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('restaurantes');
    }
}
