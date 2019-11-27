<?php

namespace App\Models;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Contracts\Auth\Authenticatable;

class Proveedores extends BaseModel
{
    use SoftDeletes;
    protected $generarID = false;
    protected $guardarIDUsuario = false;
    protected $guardarIDServidor = false;
    protected $fillable = ["nombre", "telefono", "estatus_id"];
    public $incrementing = true;

    protected $table = 'proveedores';  
}
