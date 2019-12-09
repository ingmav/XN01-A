<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response as HttpResponse;

use App\Http\Requests;
use App\Models\Ventas;
use App\Models\Produccion;

use Illuminate\Support\Facades\Input;
use \Validator,\Hash, \Response;

class ProduccionController extends Controller
{
    public function index()
    {
        $parametros = Input::only('q','page','per_page', 'etapa_produccion');
        $obj = Produccion::with("ventas.ventas_detalles.articulo", "ventas.cliente")->where("estatus", 0);


        switch($parametros['etapa_produccion'])
        {
            case 1: //Impresion
                $obj = $obj->where("diseno", 1)
                ->whereIn("estatus_diseno", [0, 2]);
            break;
            case 2: //Impresion gran formato
                $obj = $obj->where("impresion_gf", 1)
                ->whereIn("estatus_impresion_gf", [0, 2])
                ->where(function ($query) {
                    $query->Where('diseno', '=', 0)
                          ->orWhere('diseno', '=', 1)
                          ->where('estatus_diseno', '=', 1);
                });    
            break;
            case 3: //Impresion digital
                $obj = $obj->where("impresion_digital", 1)
                ->whereIn("estatus_impresion_digital", [0, 2])
                ->where(function ($query) {
                    $query->Where('diseno', '=', 0)
                          ->orWhere('diseno', '=', 1)
                          ->where('estatus_diseno', '=', 1);
                });    
            break;
            case 4: // Preparacion
                $obj = $obj->where("preparacion", 1)
                ->where(function ($query) {
                    $query->Where('diseno', '=', 0)
                          ->orWhere('diseno', '=', 1)
                          ->where('estatus_diseno', '=', 1);
                })
                ->where(function ($query) {
                    $query->Where('impresion_gf', '=', 0)
                          ->orWhere('impresion_gf', '=', 1)
                          ->where('estatus_impresion_gf', '=', 1);
                })
                ->where(function ($query) {
                    $query->Where('impresion_digital', '=', 0)
                          ->orWhere('impresion_digital', '=', 1)
                          ->where('estatus_impresion_digital', '=', 1);
                })
                ->where(function ($query) {
                    $query->whereIn("estatus_preparacion", [0, 2])
                            ->orWhereIn("estatus_instalacion", [0, 2])    
                            ->orWhereIn("estatus_entrega", [0, 2]);    
                }); 
            break;
            /*case 5: // Instalacion
                $obj = $obj->where("instalacion", 1)
                ->whereIn("estatus_instalacion", [0, 2])
                ->where(function ($query) {
                    $query->Where('diseno', '=', 0)
                          ->orWhere('diseno', '=', 1)
                          ->where('estatus_diseno', '=', 1);
                })
                ->where(function ($query) {
                    $query->Where('impresion_gf', '=', 0)
                          ->orWhere('impresion_gf', '=', 1)
                          ->where('estatus_impresion_gf', '=', 1);
                })
                ->where(function ($query) {
                    $query->Where('impresion_digital', '=', 0)
                          ->orWhere('impresion_digital', '=', 1)
                          ->where('estatus_impresion_digital', '=', 1);
                })
                ->where(function ($query) {
                    $query->Where('preparacion', '=', 0)
                          ->orWhere('preparacion', '=', 1)
                          ->where('estatus_preparacion', '=', 1);
                });    
            break;
            case 6: // Entrega
                $obj = $obj->where("entrega", 1)
                ->whereIn("estatus_entrega", [0, 2])
                ->where(function ($query) {
                    $query->Where('diseno', '=', 0)
                          ->orWhere('diseno', '=', 1)
                          ->where('estatus_diseno', '=', 1);
                })
                ->where(function ($query) {
                    $query->Where('impresion_gf', '=', 0)
                          ->orWhere('impresion_gf', '=', 1)
                          ->where('estatus_impresion_gf', '=', 1);
                })
                ->where(function ($query) {
                    $query->Where('impresion_digital', '=', 0)
                          ->orWhere('impresion_digital', '=', 1)
                          ->where('estatus_impresion_digital', '=', 1);
                })
                ->where(function ($query) {
                    $query->Where('preparacion', '=', 0)
                          ->orWhere('preparacion', '=', 1)
                          ->where('estatus_preparacion', '=', 1);
                });    
            break;*/
            case 7: //Maquilas
                $obj = $obj->where("maquilas", 1)
                ->whereIn("estatus_maquilas", [0, 2])
                ->where(function ($query) {
                    $query->Where('diseno', '=', 0)
                          ->orWhere('diseno', '=', 1)
                          ->where('estatus_diseno', '=', 1);
                });    
            break;
        }
                            
        
        if ($parametros['q']) {
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

    public function agenda(Request $request, $id)
    {
        $mensajes = [
            
            'required'      => "required",
            'unique'        => "unique"
        ];

        $reglas = [
            'etapa_produccion'        => 'required',
        ];

        $inputs = Input::only('etapa_produccion');

        $obj = Produccion::find($id);

        if(!$obj){
            return Response::json(['error' => "No se encuentra el recurso que esta buscando."], HttpResponse::HTTP_NOT_FOUND);
        }
        

        $v = Validator::make($inputs, $reglas, $mensajes);

        if ($v->fails()) {
            return Response::json(['error' => $v->errors()], HttpResponse::HTTP_CONFLICT);
        }

        try {

            switch($inputs['etapa_produccion'])
            {
                case 1:
                    if($obj->calendario_diseno == 1)
                        $obj->calendario_diseno = 0;
                    else    
                        $obj->calendario_diseno = 1;
                break;
                case 2:
                    if($obj->calendario_impresion_gf == 1)
                        $obj->calendario_impresion_gf = 0;
                    else    
                        $obj->calendario_impresion_gf = 1;
                break;
                case 3:
                    if($obj->calendario_impresion_digital == 1)
                        $obj->calendario_impresion_digital = 0;
                    else    
                        $obj->calendario_impresion_digital = 1;
                break;
                case 4:
                    if($obj->calendario_preparacion == 1)
                        $obj->calendario_preparacion = 0;
                    else    
                        $obj->calendario_preparacion = 1;
                break;
                case 5:
                    if($obj->calendario_instalacion == 1)
                        $obj->calendario_instalacion = 0;
                    else    
                        $obj->calendario_instalacion = 1;
                break;
                case 6:
                    if($obj->calendario_entrega == 1)
                        $obj->calendario_entrega = 0;
                    else    
                        $obj->calendario_entrega = 1;
                break;
                case 7:
                    if($obj->calendario_maquilas == 1)
                        $obj->calendario_maquilas = 0;
                    else    
                        $obj->calendario_maquilas = 1;
                break;
            }
            
            $obj->update();
            return Response::json([ 'data' => $obj ],200);

        } catch (\Exception $e) {
            DB::rollback();
            return Response::json(['error' => $e->getMessage()], HttpResponse::HTTP_CONFLICT);
        } 
    }
    
    public function iniciar_proceso(Request $request, $id)
    {
        $mensajes = [
            
            'required'      => "required",
            'unique'        => "unique"
        ];

        $reglas = [
            'etapa_produccion'        => 'required',
        ];

        $inputs = Input::only('etapa_produccion');

        $obj = Produccion::find($id);

        if(!$obj){
            return Response::json(['error' => "No se encuentra el recurso que esta buscando."], HttpResponse::HTTP_NOT_FOUND);
        }
        

        $v = Validator::make($inputs, $reglas, $mensajes);

        if ($v->fails()) {
            return Response::json(['error' => $v->errors()], HttpResponse::HTTP_CONFLICT);
        }

        try {

            switch($inputs['etapa_produccion'])
            {
                case 1:
                    if($obj->estatus_diseno == 2)
                        $obj->estatus_diseno = 0;
                    else    
                        $obj->estatus_diseno = 2;
                break;
                case 2:
                    if($obj->estatus_impresion_gf == 2)
                        $obj->estatus_impresion_gf = 0;
                    else    
                        $obj->estatus_impresion_gf = 2;
                break;
                case 3:
                    if($obj->estatus_impresion_digital == 2)
                        $obj->estatus_impresion_digital = 0;
                    else    
                        $obj->estatus_impresion_digital = 2;
                break;
                case 4:
                    if($obj->estatus_preparacion == 2)
                        $obj->estatus_preparacion = 0;
                    else    
                        $obj->estatus_preparacion = 2;
                break;
                case 5:
                    if($obj->estatus_instalacion == 2)
                        $obj->estatus_instalacion = 0;
                    else    
                        $obj->estatus_instalacion = 2;
                break;
                case 6:
                    if($obj->estatus_entrega == 2)
                        $obj->estatus_entrega = 0;
                    else    
                        $obj->estatus_entrega = 2;
                break;
                case 7:
                    if($obj->estatus_maquilas == 2)
                        $obj->estatus_maquilas = 0;
                    else    
                        $obj->estatus_maquilas = 2;
                break;
            }
            
            $obj->update();
            return Response::json([ 'data' => $obj ],200);

        } catch (\Exception $e) {
            DB::rollback();
            return Response::json(['error' => $e->getMessage()], HttpResponse::HTTP_CONFLICT);
        } 
    }

    public function finalizar_proceso(Request $request, $id)
    {
        $mensajes = [
            
            'required'      => "required",
            'unique'        => "unique"
        ];

        $reglas = [
            'etapa_produccion'        => 'required',
        ];

        $inputs = Input::only('etapa_produccion');

        $obj = Produccion::find($id);

        if(!$obj){
            return Response::json(['error' => "No se encuentra el recurso que esta buscando."], HttpResponse::HTTP_NOT_FOUND);
        }
        

        $v = Validator::make($inputs, $reglas, $mensajes);

        if ($v->fails()) {
            return Response::json(['error' => $v->errors()], HttpResponse::HTTP_CONFLICT);
        }

        try {

            switch($inputs['etapa_produccion'])
            {
                case 1:
                    $obj->estatus_diseno = 1;
                break;
                case 2:
                    $obj->estatus_impresion_gf = 1;
                break;
                case 3:
                    $obj->estatus_impresion_digital = 1;
                break;
                case 4:
                    $obj->estatus_preparacion = 1;
                break;
                case 5:
                    $obj->estatus_instalacion = 1;
                break;
                case 6:
                    $obj->estatus_entrega = 1;
                break;
                case 7:
                    $obj->estatus_maquilas = 1;
                break;
            }
            
            $obj->update();
            return Response::json([ 'data' => $obj ],200);

        } catch (\Exception $e) {
            DB::rollback();
            return Response::json(['error' => $e->getMessage()], HttpResponse::HTTP_CONFLICT);
        } 
    }
}
