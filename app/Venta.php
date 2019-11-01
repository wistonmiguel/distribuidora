<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Venta extends Model
{
    protected $table = "Venta";
    protected $primaryKey = 'idTransaccion';
    public $timestamps = false;
}
