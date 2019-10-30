<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CompraDetalleDevolucion extends Model
{
    protected $table = "detalledev_compra";
    protected $primaryKey = 'idDetalle';
    public $timestamps = false;
}
