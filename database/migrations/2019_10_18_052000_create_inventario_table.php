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
            $table->bigIncrements('idInventario');
            $table->unsignedInteger('Stock');
            $table->string('Und_Medida');
            $table->string('Presentacion');
            $table->unsignedBigInteger('idProducto'); // Relación con Producto
            $table->foreign('idProducto')->references('idProducto')->on('producto'); // clave foranea
            $table->unsignedBigInteger('idAlmacen'); // Relación con Almacen
            $table->foreign('idAlmacen')->references('idAlmacen')->on('almacen'); // clave foranea
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
