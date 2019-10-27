<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CompraDetalle extends Model
{
    protected $table = "detallecompra";
    protected $primaryKey = 'idDetalle';
    public $timestamps = false;
}
