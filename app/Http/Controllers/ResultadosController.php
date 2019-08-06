<?php

namespace App\Http\Controllers;
require_once 'Objeto.php';

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use App\Pregunta;
use App\EncuestaPregunta;
use App\Departamento;
use App\Resultado;
use App\Encuesta;

class ResultadosController extends Controller
{

    public function select()
    {
        return view('resultados');
        $departamentos= Departamento::select('id','nombre')->get();
        return view('selectDepartamentoResultados', compact('departamentos'));
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

        $resultado_encuesta_obj=[];
        // Codigo real
//        $encuestasDisponibles= Resultado::distinct()->pluck('encuesta_id');
//        $encuestasDisponibles= Resultado::distinct()->where('id',1)->first();
//        $encuestasDisponibles= Resultado::distinct()->first();
//        return $encuestasDisponibles;

//        $x= Resultado::where('encuesta_id',1)->where('pregunta_id',1)->count();
//        return $x;
        // Obtener todas las respuestas de todas las encuestas que hayan sido contestados por empleados de x departamento
        $q= Resultado::whereHas('empleado',function($query) use ($idDepartamento) {
            $query->where('departamento_id',$idDepartamento);
        });

        $encuestasDisponibles=$q->distinct()->pluck('encuesta_id');
        $resultados= $q->get();

        foreach($encuestasDisponibles as $encuesta){ // $encuesta es el id de la encuesta
            $preguntas=Encuesta::find($encuesta)->preguntas;
            foreach($preguntas as $pregunta){
                return $pregunta->id;
            }
            $q->where('encuesta_id',$encuesta)->count();
        }



//        return $resultados[1]->empleado->departamento;
        return view('resultados', compact('departamentos','idDepartamento','resultadosObj'));
    }
}
