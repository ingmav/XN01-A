<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response as HttpResponse;

use App\Http\Requests;
use App\Models\Ventas;

use Illuminate\Support\Facades\Input;
use \Validator,\Hash, \Response;

class TrabajosPendientesController extends Controller
{
    public function index()
    {
        $parametros = Input::only('q','page','per_page');
        $obj = Ventas::with("cliente")->where("estatus_produccion", 0);
        
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
}
