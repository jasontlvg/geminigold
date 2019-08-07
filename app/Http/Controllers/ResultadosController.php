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
//        $resultadosObj=new Objeto();
//        array_push($teclado->respuestas,'Si puedes imaginarlo, puedes programarlo');
//        return $teclado->respuestas;
        $idDepartamento=6;
        $departamentos= Departamento::select('id','nombre')->get();
        if(!$departamentos){
            return 'No existe';
        }
        // Obtener todas las respuestas de todas las encuestas que hayan sido contestados por empleados de x departamento
        $q= Resultado::whereHas('empleado',function($query) use ($idDepartamento) {
            $query->where('departamento_id',$idDepartamento);
        });

        $encuestasDisponibles=$q->distinct()->pluck('encuesta_id');
//        $resultados= $q->get();
        $respuestas= Respuesta::all();
//        return $respuestas;
        $encuestas= [];
//        return Response::json($encuestas);
//        return sizeof($encuestasDisponibles);

        for($encuesta=0;$encuesta<sizeof($encuestasDisponibles);$encuesta++){
//            $resultados=[];
            $preguntasObj=[];
            array_push($encuestas,new EncuestaObj);

            // Agregando el Nombre de la Encuesta
            $preguntas=Encuesta::find($encuestasDisponibles[$encuesta])->preguntas;
            $nombreEncuesta= Encuesta::find($preguntas[0]->pivot->encuesta_id)->nombre;
            $encuestas[$encuesta]->nombreEncuesta=$nombreEncuesta;

            // Agregando las Respuestas Posibles
            foreach($respuestas as $respuesta){
                array_push($encuestas[$encuesta]->respuestas,$respuesta->respuesta);
            }

            // Agregando preguntas arreglo

        }
        return Response::json($encuestas);
//        return $encuestas;
        return view('resultados', compact('departamentos','idDepartamento'));
    }
}
