<?php
namespace App\Models;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Contracts\Auth\Authenticatable;

class Usuario extends BaseModel implements Authenticatable{
    
    use SoftDeletes;
    protected $generarID = false;
    protected $guardarIDUsuario = false;
    protected $fillable = ["id","servidor_id","password","nombre","apellidos","avatar","su", "id_jurisdiccion"];

    protected $hidden = array('pivot');
    
    public function roles(){
        return $this->belongsToMany('App\Models\Rol', 'rol_usuario', 'usuario_id', 'rol_id');
	}

    public function almacenes(){
        return $this->belongsToMany('App\Models\Almacen','almacen_usuario','usuario_id','almacen_id');
    }

    public function unidadesMedicas(){
        return $this->belongsToMany('App\Models\UnidadMedica','usuario_unidad_medica','usuario_id','clues')->orderBy('nombre');
    }

    public function usuariounidad(){
        return $this->hasOne('App\Models\UsuarioUnidad','usuario_id');
    }

    public function usuarioTema(){
        return $this->belongsToMany('App\Models\Temas', 'rel_usuario_tema', 'usuario_id', 'id_tema');
    }

    

   

    /**
     * @return string
     */
    public function getAuthIdentifierName()
    {
        // Return the name of unique identifier for the user (e.g. "id")
    }

    /**
     * @return mixed
     */
    public function getAuthIdentifier()
    {
        // Return the unique identifier for the user (e.g. their ID, 123)
    }

    /**
     * @return string
     */
    public function getAuthPassword()
    {
        // Returns the (hashed) password for the user
    }

    /**
     * @return string
     */
    public function getRememberToken()
    {
        // Return the token used for the "remember me" functionality
    }

    /**
     * @param  string  $value
     * @return void
     */
    public function setRememberToken($value)
    {
        // Store a new token user for the "remember me" functionality
    }

    /**
     * @return string
     */
    public function getRememberTokenName()
    {
        // Return the name of the column / attribute used to store the "remember me" token
    }

}