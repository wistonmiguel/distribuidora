<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VentaDetalleDevolucion extends Model
{
    protected $table = "detalledev_venta";
    protected $primaryKey = 'idDetalle';
    public $timestamps = false;
}
