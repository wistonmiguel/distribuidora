<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('productos', function (Blueprint $table) {
            $table->bigIncrements('idProducto');
            $table->string('Descripcion');
            $table->string('Marca');
            $table->unsignedBigInteger('idProveedor'); // Relación con Proveedor
            $table->foreign('idProveedor')->references('idProveedor')->on('proveedores'); // clave foranea
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('productos');
    }
}
