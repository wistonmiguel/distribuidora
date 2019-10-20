<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInventarioTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inventario', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('idAlmacen'); // Relación con Almacen
            $table->foreign('idAlmacen')->references('idAlmacen')->on('almacen'); // clave foranea
            $table->unsignedBigInteger('idProveedor'); // Relación con Proveedor
            $table->foreign('idProveedor')->references('idProveedor')->on('proveedor'); // clave foranea
        });        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('inventario');
    }
}
