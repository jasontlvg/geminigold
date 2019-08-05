<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use App\Pregunta;
use App\EncuestaPregunta;
use App\Departamento;
use App\Resultado;

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
        $departamentos= Departamento::select('id','nombre')->get();
        if(!$departamentos){
            return 'No existe';
        }

        // Codigo real
        $encuestasDisponibles= Resultado::distinct()->pluck('encuesta_id');
//        return $encuestasDisponibles;

        $x= Resultado::where('encuesta_id',1)->where('pregunta_id',1)->count();
//        return $x;
        // Obtener todas las respuestas de todas las encuestas que hayan sido contestados por empleados de x departamento
        $resultados= Resultado::whereHas('empleado',function($query) use ($idDepartamento) {
            $query->where('departamento_id',$idDepartamento);
        })->get();




//        return $resultados[1]->empleado->departamento;
        return $resultados;
        return view('resultados', compact('departamentos','idDepartamento','resultados'));
    }
}
