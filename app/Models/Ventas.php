<?php

namespace App\Models;

use App\Models\BaseModel;

class Ventas extends BaseModel
{
    protected $generarID = false;
    protected $guardarIDServidor = false;
    //protected $guardarIDUsuario = false;
    public $incrementing = true;

    
    protected $table = 'ms_ventas';  
    protected $fillable = [];

    public function cliente()
    {
        return $this->hasOne("App\Models\Cliente", "id", "cliente_id");
    }
}
