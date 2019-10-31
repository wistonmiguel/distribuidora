<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PedidoDetalle extends Model
{
    protected $table = "detallepedido";
    protected $primaryKey = 'idDetalle';
    public $timestamps = false;
}
