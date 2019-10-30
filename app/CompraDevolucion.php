<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CompraDevolucion extends Model
{
    protected $table = "dev_compra";
    protected $primaryKey = 'idTransaccion';
    public $timestamps = false;
}
