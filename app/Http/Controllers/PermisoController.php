<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response as HttpResponse;

use App\Http\Requests;
use App\Models\Permiso;

use Illuminate\Support\Facades\Input;
use \Validator,\Hash, \Response;



class PermisoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $parametros = Input::only('q','page','per_page');
        if ($parametros['q']) {
             $permisos =  Permiso::where('descripcion','LIKE',"%".$parametros['q']."%")->orderBy('grupo','asc');
        } else {
             $permisos =  Permiso::select('*')->orderBy('grupo','asc');
        }
        // No podemos mostrar los permisos de superusuario a menos que seas super usuario
        $permisos = $permisos->where('su',false);

        if(isset($parametros['page'])){

            $resultadosPorPagina = isset($parametros["per_page"])? $parametros["per_page"] : 20;
            $permisos = $permisos->paginate($resultadosPorPagina);
        } else {
            $permisos = $permisos->get();
        }
       
        return Response::json([ 'data' => $permisos],200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $mensajes = [
            'required'      => "required",
        ];

        $reglas = [
            'descripcion'   => 'required',
            'grupo'         => 'required'
        ];

        $inputs = Input::only('descripcion', 'grupo');
        $v = Validator::make($inputs, $reglas, $mensajes);

        if ($v->fails()) {
            return Response::json(['error' => $v->errors()], HttpResponse::HTTP_CONFLICT);
        }

        try {
            $inputs['id'] = str_random(32);
            $permiso = Permiso::create($inputs);

            return Response::json([ 'data' => $permiso ],200);

        } catch (\Exception $e) {
            return Response::json(['error' => $e->getMessage()], HttpResponse::HTTP_CONFLICT);
        } 
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
