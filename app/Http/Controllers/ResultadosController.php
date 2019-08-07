<?php

namespace App\Http\Controllers;

use Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use App\Pregunta;
use App\EncuestaPregunta;
use App\Departamento;
use App\Resultado;
use App\Encuesta;
use App\Respuesta;
use App\Classes\Objeto;
use App\Classes\EncuestaObj;
use App\Classes\PreguntaObj;

class ResultadosController extends Controller
{

    public function select()
    {
//        return view('resultados');
        return view('selectDepartamentoResultados');
    }

    public function show($idDepartamento)
    {
        $idDepartamento=6;
        $departamentos= Departamento::select('id','nombre')->get();
        if(!$departamentos){
            return 'No existe';
        }
        // Obtener todas las respuestas de todas las encuestas que hayan sido contestados por empleados de x departamento
        $q= Resultado::whereHas('empleado',function($query) use ($idDepartamento) {
            $query->where('departamento_id',$idDepartamento);
        });

        $sql= Resultado::whereHas('empleado',function($query) use ($idDepartamento) {
            $query->where('departamento_id',$idDepartamento);
        });

        $encuestasDisponibles=$q->distinct()->select('encuesta_id')->with('encuesta')->get();
        $respuestas= Respuesta::all();
        $resultados= $sql->get();
//        return $resultados;

//        return $encuestasDisponibles;

        $encuestasJS=[]; // El array que mandaremos a JS
        foreach($encuestasDisponibles as $ed){
            $ed= $ed->encuesta; // Cada $encuesta es un objeto, como usamos with, viene con los datos de la Encuesta de la tabla encuesta, a nosotros solo nos interesan esos datos, por eso puse eso, porque tambien sale el id de esa encuesta dos veces, y ya viene, asi que no la ocupo
//            return $ed;
            array_push($encuestasJS,new EncuestaObj);
            $encuesta=end($encuestasJS); // Obtenemos la Encuesta ACTUAL (obj) a agregar datos
            $encuesta->nombreEncuesta=$ed->nombre;
            foreach($respuestas as $r){
                array_push($encuesta->respuestas,$r->respuesta);
            }
            $preguntas=Encuesta::find($ed->id)->preguntas;
            foreach($preguntas as $pregunta){
//                return $pregunta;
                array_push($encuesta->preguntas,new PreguntaObj);
                $pr= end($encuesta->preguntas);
                $pr->question=$pregunta->pregunta; //aqui llenamos $encuesta.preguntas.question
//                return $respuestas;
                // Aqui
                foreach($respuestas as $r){
//                    return $r;
                    foreach($resultados as $re){
                        $i=0;
                        if($re->encuesta_id==$ed->id && $re->pregunta_id==$pregunta->id && $re->respuesta_id==6){
                            $i++;
                        }
                    }
                    array_push($pr->results,$i);
//                    $res= $sql->where('encuesta_id',$ed->id)->where('pregunta_id',$pregunta->id)->where('respuesta_id',1)->count();
                }
            }
        }
        return Response::json($encuestasJS);
        return view('resultados', compact('departamentos','idDepartamento','encuestasJS'));
    }
}
