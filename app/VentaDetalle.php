<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VentaDetalle extends Model
{
    protected $table = "detalleventa";
    protected $primaryKey = 'idDetalle';
    public $timestamps = false;
}
