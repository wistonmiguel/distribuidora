<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comprador extends Model
{
    protected $table = "comprador";
    protected $primaryKey = 'idComprador';
    public $timestamps = false;
}
