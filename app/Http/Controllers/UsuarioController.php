<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response as HttpResponse;

use App\Http\Requests;
use App\Models\Usuario, App\Models\RelUsuarioTema;
use Illuminate\Support\Facades\Input;
use \Validator,\Hash, \Response, \DB;

class UsuarioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //return Response::json([ 'data' => []],200);
        //return Response::json(['error' => ""], HttpResponse::HTTP_UNAUTHORIZED);
        $parametros = Input::only('q','page','per_page');
        if ($parametros['q']) {
             $usuarios =  Usuario::where('su',false)->where(function($query) use ($parametros) {
                 $query->where('id','LIKE',"%".$parametros['q']."%")->orWhere(DB::raw("CONCAT(nombre,' ',apellidos)"),'LIKE',"%".$parametros['q']."%");
             });
        } else {
             $usuarios =  Usuario::where('su',false);
        }
        

        if(isset($parametros['page'])){

            $resultadosPorPagina = isset($parametros["per_page"])? $parametros["per_page"] : 20;
            $usuarios = $usuarios->paginate($resultadosPorPagina);
        } else {
            $usuarios = $usuarios->get();
        }
       
        return Response::json([ 'data' => $usuarios],200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //return Response::json(['error' => ""], HttpResponse::HTTP_UNAUTHORIZED);
        $mensajes = [
            
            'required'      => "required",
            'email'         => "email",
            'unique'        => "unique"
        ];

        $reglas = [
            'id'            => 'required|email|unique:usuarios',
            'password'      => 'required',
            'nombre'        => 'required',
            'apellidos'     => 'required',
            'id_jurisdiccion' => 'required',
        ];

        $inputs = Input::only('id','servidor_id','password','nombre', 'apellidos','avatar','roles','temas', 'id_jurisdiccion');

        $v = Validator::make($inputs, $reglas, $mensajes);

        if ($v->fails()) {
            return Response::json(['error' => $v->errors()], HttpResponse::HTTP_CONFLICT);
        }

       
        DB::beginTransaction();
        try {
            $inputs['servidor_id'] = env("SERVIDOR_ID");
            $inputs['password'] = Hash::make($inputs['password']);
            $usuario = Usuario::create($inputs);
            
            $usuario->roles()->sync($inputs['roles']);
            
            $arreglo_temas = [];
            foreach ($inputs['temas'] as $key => $value) {
                $index = count($arreglo_temas);
                $arreglo_temas[$index]['usuario_id'] = $usuario->id;
                $arreglo_temas[$index]['id_tema'] = $value['id'];
            }
            //
            $relacion = RelUsuarioTema::insert($arreglo_temas);
            DB::commit();
            return Response::json([ 'data' => $usuario ],200);

        } catch (\Exception $e) {
             DB::rollBack();
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
        $object = Usuario::find($id);
        
        if(!$object ){
            
            return Response::json(['error' => "No se encuentra el recurso que esta buscando."], HttpResponse::HTTP_NOT_FOUND);
        }
        unset($object->password);
        $object->roles;
        $object->usuarioTema;

        /*foreach ($object->usuarioTema as $key => $value) {
            unset($object->usuarioTema[$key]['pivot']);
        }*/
        

        return Response::json([ 'data' => $object ], HttpResponse::HTTP_OK);
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
            'email'         => "email",
            'unique'        => "unique"
        ];

        $reglas = [
            'id'            => 'required|email|unique:usuarios,id,'.$id,
            'password'      => 'required_with:cambiarPassword',
            'nombre'        => 'required',
            'apellidos'     => 'required'
        ];
        $object = Usuario::find($id);

        if(!$object){
            return Response::json(['error' => "No se encuentra el recurso que esta buscando."], HttpResponse::HTTP_NOT_FOUND);
        }

        $inputs = Input::only('id','servidor_id','password','nombre', 'apellidos','avatar','roles','cambiarPassword','temas', 'id_jurisdiccion');

        $v = Validator::make($inputs, $reglas, $mensajes);

        if ($v->fails()) {
            return Response::json(['error' => $v->errors()], HttpResponse::HTTP_CONFLICT);
        }

        DB::beginTransaction();
        try {
            $object->nombre =  $inputs['nombre'];
            $object->apellidos =  $inputs['apellidos'];
            $object->avatar =  $inputs['avatar'];
            $object->id =  $inputs['id'];
            $object->id_jurisdiccion =  $inputs['id_jurisdiccion'];
            if ($inputs['cambiarPassword'] ){
                $object->password = Hash::make($inputs['password']);
            }
            
            $object->save();

            $object->roles()->sync($inputs['roles']);

            $arreglo_temas = [];
            foreach ($inputs['temas'] as $key => $value) {                
                $arreglo_temas[] = $value['id'];
            }

            $object->usuarioTema()->sync($arreglo_temas);
            
            //return Response::json([ 'data' => "bien hassta aca" ],500);
            DB::commit();
            return Response::json([ 'data' => $object ],200);

        } catch (\Exception $e) {
            DB::rollback();
            return Response::json(['error' => $e->getMessage()], HttpResponse::HTTP_CONFLICT);
        } 

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
    //return Response::json(['error' => ""], HttpResponse::HTTP_UNAUTHORIZED);
       try {
			$object = Usuario::destroy($id);
			return Response::json(['data'=>$object],200);
		} catch (Exception $e) {
		   return Response::json(['error' => $e->getMessage()], HttpResponse::HTTP_CONFLICT);
		}
    }
}
