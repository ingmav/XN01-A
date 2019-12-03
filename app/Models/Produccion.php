<?php

namespace App\Models;

use App\Models\BaseModel;

class Produccion extends BaseModel
{
    protected $generarID = false;
    protected $guardarIDServidor = false;
    protected $guardarIDUsuario = false;
    public $incrementing = true;

    
    protected $table = 'msw_produccion';  
    protected $fillable = ['diseno', "impresion", "preparacion", "instalacion", "entrega", "maquilas", "ventas_id"];

    public function ventas()
    {
        return $this->belongsTo("App\Models\Ventas");
    }
}
