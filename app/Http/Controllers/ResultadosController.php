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
        $idDepartamento=1;
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
                array_push($encuesta->respuestas,$r->respuesta); // Aqui llenamos $encuesta.respuestas
            }

            $preguntas=Encuesta::find($ed->id)->preguntas;
//            return $sql->get();
//          $encuesta->preguntas ---> retorna un array
            foreach($preguntas as $pregunta){
//                return $pregunta;
                array_push($encuesta->preguntas,new PreguntaObj); // Por cada pregunta, se agrega un objeto
                // Arriba agregamos el objeto, el cual representa una pregunta, aqui lo que hacemos es
                // tomar ese objeto que acabamos agregar al arreglo, como ya sabemos que el objeto que
                // representa una pregunta lo acabamos de agregar, quiere decir que esta al final del
                // arreglo
                $qr= end($encuesta->preguntas); // TLX
                $qr->question=$pregunta->pregunta;
                $results= $qr->results;
//                return $respuestas;
                // Aqui ocupo: el id de la pregunta, el id de la encuesta
                foreach($respuestas as $respuesta){

                    $i=0;
                    foreach($resultados as $resultado){
//                        return $resultado;
//                        return $ed->id;
//                        return $pregunta->id;
//                        return $respuesta->id;
                        if($resultado->encuesta_id==$ed->id && $resultado->pregunta_id==$pregunta->id && $resultado->respuesta_id==$respuesta->id){
                            $i++;
                        }
                    }
                    array_push($qr->results,$i);

                }
            }
        }
//        $teclado= Response::json($encuestasJS);
        $calabaza='Calabaza';
        return view('resultados', compact('departamentos','idDepartamento','encuestasJS','calabaza'));
    }
}
