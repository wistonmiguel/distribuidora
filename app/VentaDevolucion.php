<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VentaDevolucion extends Model
{
    protected $table = "dev_venta";
    protected $primaryKey = 'idTransaccion';
    public $timestamps = false;
}
