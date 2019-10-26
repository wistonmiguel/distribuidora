<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Compra extends Model
{
    protected $table = "Compra";
    protected $primaryKey = 'idTransaccion';
    public $timestamps = false;
}
