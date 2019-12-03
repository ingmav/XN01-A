<?php

namespace App\Models;

use App\Models\BaseModel;

class Articulo extends BaseModel
{
    protected $generarID = false;
    protected $guardarIDServidor = false;
    //protected $guardarIDUsuario = false;
    public $incrementing = true;

    
    protected $table = 'ms_articulos';  
    protected $fillable = [];

    
}
