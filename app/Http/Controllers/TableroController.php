<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response as HttpResponse;

use App\Http\Requests;
use App\Models\Ventas;
use App\Models\Produccion;

use Illuminate\Support\Facades\Input;
use \Validator,\Hash, \Response;

class TableroController extends Controller
{
    public function index()
    {
        $parametros = Input::only('q','page','per_page');
        //$obj = Ventas::with("cliente", "ventas_detalles.articulo")->where("estatus_produccion", 0);
        $obj = Produccion::with("ventas.cliente", "ventas.ventas_detalles")->where("estatus", 0);
        
        if ($parametros['q']) {
            /*$obj = $obj->with(["ventas.cliente", "ventas.ventas_detalles", "ventas" => function($query) use($parametros)
            {
                $query->where('folio', "like", "%".$parametros['q']."%");
            }]);*/
             $obj =  $obj->where('folio','LIKE',"%".$parametros['q']."%");
        } else {
             $obj =  $obj->select('*');
        }
        
        if(isset($parametros['page'])){

            $resultadosPorPagina = isset($parametros["per_page"])? $parametros["per_page"] : 20;
            $obj = $obj->paginate($resultadosPorPagina);
        } else {
            $obj = $obj->get();
        }
       
        return Response::json([ 'data' => $obj],200);
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
        $mensajes = [
            'required'      => "required",
        ];

        $reglas = [
            'tipo'   => 'required',
            'estatus'   => 'required'
        ];

        $inputs = Input::only('tipo', 'estatus');
        $v = Validator::make($inputs, $reglas, $mensajes);

        if ($v->fails()) {
            return Response::json(['error' => $v->errors()], HttpResponse::HTTP_CONFLICT);
        }

        try {
            
            $obj = Produccion::find($id);
            
            switch($inputs['tipo'])
            {
                case 1:
                    if($inputs['estatus'] == 1)
                        $obj->estatus_diseno = 0;
                    if($inputs['estatus'] == 0)
                        $obj->estatus_diseno = 1;
                break;
                case 2:
                    if($inputs['estatus'] == 1)
                        $obj->estatus_impresion_gf = 0;
                    if($inputs['estatus'] == 0)
                        $obj->estatus_impresion_gf = 1;
                break;
                case 3:
                    if($inputs['estatus'] == 1)
                        $obj->estatus_impresion_digital = 0;
                    if($inputs['estatus'] == 0)
                        $obj->estatus_impresion_digital = 1;
                break;
                case 4:
                    if($inputs['estatus'] == 1)
                        $obj->estatus_preparacion = 0;
                    if($inputs['estatus'] == 0)
                        $obj->estatus_preparacion = 1;
                break;
                case 5:
                    if($inputs['estatus'] == 1)
                        $obj->estatus_instalacion = 0;
                    if($inputs['estatus'] == 0)
                        $obj->estatus_instalacion = 1;
                break;
                case 6:
                    if($inputs['estatus'] == 1)
                        $obj->estatus_entrega = 0;
                    if($inputs['estatus'] == 0)
                        $obj->estatus_entrega = 1;
                break;
                case 7:
                    if($inputs['estatus'] == 1)
                        $obj->estatus_maquilas = 0;
                    if($inputs['estatus'] == 0)
                        $obj->estatus_maquilas = 1;
                break;

                case 10:
                    $obj->estatus = 1;
                break;
            }

            $obj->update();

            return Response::json([ 'data' => $obj ],200);

        } catch (\Exception $e) {
          
            return Response::json(['error' => $e->getMessage()], HttpResponse::HTTP_CONFLICT);
        } 
    }
}
