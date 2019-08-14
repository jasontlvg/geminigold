<?php

namespace App\Http\Controllers\API;

use App\Encuesta;
use App\Respuesta;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Departamento;
use App\Resultado;
use App\User;
class ResultsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $departamentos= Departamento::select('id','nombre')->get();
//        $departamentos= Departamento::all();
        return $departamentos;
    }

    public function encuestasDisponibles($id)
    {
        $idDepartamento=$id;
        $encuestasDisponibles=Resultado::whereHas('empleado',function($query) use ($idDepartamento) {
            $query->where('departamento_id',$idDepartamento);
        })->distinct()->select('encuesta_id')->with('encuesta')->get();

        return $encuestasDisponibles;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
//        return 'Hola';
//        if($request->get('departamento_id') == 3){
//            return 'Exito';
//        }else{
//            return 'Nada';
//        }
//        return $request->input('message');
        // Original
//        $encuesta_id=$request->get('encuesta');
//        $idDepartamento=$request->get('departamento');
//        $empleados= Departamento::with(['empleados.resultados' => function ($q) use ($encuesta_id) {
//            $q->where('encuesta_id', $encuesta_id);
//        }])->where('id',$idDepartamento)->select('id','nombre')->get();
//        return $empleados;
        $enviar=[];
        // Necesario
        $departamento=$request->get('departamento_id');
        $encuesta=$request->get('encuesta_id');
        $pregunta=$request->get('pregunta_id');

        $respuestas= Respuesta::all();
//        return $respuestas;


        foreach($respuestas as $respuesta){

            $resultados= Resultado::whereHas('empleado',function ($query) use ($departamento){
                $query->where('departamento_id',$departamento);
            })->where('encuesta_id',$encuesta)->where('pregunta_id',$pregunta)->where('respuesta_id',$respuesta->id)->count();

            array_push($enviar,$resultados);

        }

        return $enviar;

        $resultados= Resultado::whereHas('empleado',function ($query) use ($departamento){
            $query->where('departamento_id',$departamento);
        })->where('encuesta_id',$encuesta)->where('pregunta_id',$pregunta)->where('respuesta_id',6)->get();
//        return Resultado::find(1)->empleado;
        return $resultados;
    }

    public function preguntasEncuesta($id)
    {
        $preguntas= Encuesta::find($id)->preguntas;
        return $preguntas;
    }

    public function respuestas()
    {
        $respuestas= Respuesta::pluck('respuesta');
        return $respuestas;
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
