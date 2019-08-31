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

    public function encuestasDisponibles($id) // Las encuestas disponibles de ese departamento (recuerda que, digamos, para entender mejor, hay un solo empleado de ese departamento, y ese empleado nomas contesto una encuesta, entonces, solo hay resultados para esa encuesta, porque solo ese han contestado, no quiero traer todos las encuestas si no tienen resultados para ese departamento)
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

    // 2019

    public function getData($departamento)
    {
        $arr=[];
        $encuestaResultados=[];
        // Opcion 1
//        $resultados= Resultado::whereHas('empleado',function ($query) use ($departamento){
//            $query->where('departamento_id',$departamento);
//        })->get();
//        return $resultados;


        // Opcion 2
//        $encuestasDisponibles=Resultado::whereHas('empleado',function($query) use ($idDepartamento) {
//            $query->where('departamento_id',$idDepartamento);
//        })->distinct()->select('encuesta_id')->with('encuesta')->get();



        $encuestas= Encuesta::all();
        $respuestas= Respuesta::all();
        $resultadosXencuesta= [];
//        return $encuestas;

        foreach ($encuestas as $encuesta){
            $resultados= Resultado::whereHas('empleado',function ($query) use ($departamento,$encuesta){
                $query->where('departamento_id',$departamento)->where('encuesta_id', $encuesta->id);
            })->get();
            array_push($resultadosXencuesta, $resultados);
        }
//        return $resultadosXencuesta;
        $resultadosDeLasPreguntasPorEncuesta=[];
        foreach($resultadosXencuesta as $resultadosEncuesta){
            // Despues de dividir los resultados
            // por encuesta, seleccionamos los resultados de una encuesta nadamas
            // $resultadosEncuesta, es una lista con todas las respuestas
            $encuesta_id= $resultadosEncuesta[0]->encuesta_id;

            $preguntas= Encuesta::find($encuesta_id)->preguntas;
//            return $preguntas;
            $l=[]; // Una $l representa los resultados de una sola pregunta de una Encuesta
            foreach ($preguntas as $pregunta){
                $preguntaId= $pregunta->id;
//                return $pregunta->pregunta;
                $personasQueContestaron1=0;
                $personasQueContestaron2=0;
                $personasQueContestaron3=0;
                $personasQueContestaron4=0;
                $personasQueContestaron5=0;
                $personasQueContestaron6=0;
                foreach ($resultadosEncuesta as $resultado){
                    if($resultado->pregunta_id == $preguntaId){

                        if($resultado->respuesta_id == 1){
                            $personasQueContestaron1++;
                        }

                        if($resultado->respuesta_id == 2){
                            $personasQueContestaron2++;
                        }

                        if($resultado->respuesta_id == 3){
                            $personasQueContestaron3++;
                        }


                        if($resultado->respuesta_id == 4){
                            $personasQueContestaron4++;
                        }


                        if($resultado->respuesta_id == 5){
                            $personasQueContestaron5++;
                        }


                        if($resultado->respuesta_id == 6){
                            $personasQueContestaron6++;
                        }



                    }

                }

                array_push($l, $personasQueContestaron1);
                array_push($l, $personasQueContestaron2);
                array_push($l, $personasQueContestaron3);
                array_push($l, $personasQueContestaron4);
                array_push($l, $personasQueContestaron5);
                array_push($l, $personasQueContestaron6);
//                return $l;

//                array_push($encuestaResultados, $l)
                array_push($arr,$l);
                $l=[];

            }

        }
        return $arr;
    }
}
