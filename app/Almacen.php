<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Almacen extends Model
{
    protected $table = "almacenes";
    protected $primary_key = 'idAlmacen';
    public $timestamps = false;
}
