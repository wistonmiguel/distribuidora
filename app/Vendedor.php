<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Vendedor extends Model
{
    protected $table = "vendedor";
    protected $primaryKey = 'idVendedor';
    public $timestamps = false;
}
