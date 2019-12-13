<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response as HttpResponse;

use App\Http\Requests;
use App\Models\Ventas;
use App\Models\Produccion;

use Illuminate\Support\Facades\Input;
use \Validator,\Hash, \Response;

class TrabajosPendientesController extends Controller
{
    public function index()
    {
        $parametros = Input::only('q','page','per_page');
        $obj = Ventas::with("cliente", "ventas_detalles.articulo")->where("estatus_produccion", 0);
        
        if ($parametros['q']) {
             //$obj =  $obj->where('folio','LIKE',"%".$parametros['q']."%");
             $obj =  $obj->whereRaw("cliente_id in (select id from ms_clientes where nombre like '%".$parametros['q']."%')")->orWhere('folio','LIKE',"%".$parametros['q']."%");
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
            'diseno'   => 'required',
            'impresion_gf'   => 'required',
            'impresion_d'   => 'required',
            'instalacion'   => 'required',
            'preparacion'   => 'required',
            'entrega'   => 'required',
            'maquilas'   => 'required',
            'ventas_id'   => 'required'
        ];

        $inputs = Input::only('diseno', "impresion_gf", "impresion_d", "preparacion", "instalacion", "entrega", "maquilas", "ventas_id", "descripcion");
        $v = Validator::make($inputs, $reglas, $mensajes);

        if ($v->fails()) {
            return Response::json(['error' => $v->errors()], HttpResponse::HTTP_CONFLICT);
        }

        try {
            
            $obj = new Produccion;
            $obj->ventas_id = $inputs['ventas_id'];
            $obj->diseno =  $inputs['diseno'];
            $obj->estatus_diseno = 0;
            $obj->calendario_diseno = 0;
            $obj->impresion_gf =  $inputs['impresion_gf'];
            $obj->estatus_impresion_gf = 0;
            $obj->calendario_impresion_gf = 0;
            $obj->impresion_digital =  $inputs['impresion_d'];
            $obj->estatus_impresion_digital = 0;
            $obj->calendario_impresion_digital = 0;
            $obj->preparacion =  $inputs['preparacion'];
            $obj->estatus_preparacion = 0;
            $obj->calendario_preparacion = 0;
            $obj->instalacion =  $inputs['instalacion'];
            $obj->estatus_instalacion = 0;
            $obj->calendario_instalacion = 0;
            $obj->entrega =  $inputs['entrega'];
            $obj->estatus_entrega = 0;
            $obj->calendario_entrega = 0;
            $obj->maquilas =  $inputs['maquilas'];
            $obj->estatus_maquilas = 0;
            $obj->calendario_maquilas = 0;
            $obj->estatus = 0;
            $obj->detalles = $inputs['descripcion'];
            $obj->save();
            
            $update_venta = Ventas::find($inputs['ventas_id']);
            $update_venta->estatus_produccion = 1;
            $update_venta->update();


            return Response::json([ 'data' => $obj ],200);

        } catch (\Exception $e) {
          
            return Response::json(['error' => $e->getMessage()], HttpResponse::HTTP_CONFLICT);
        } 
    }
}
