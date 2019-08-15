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
use function foo\func;

class ResultadosController extends Controller
{

    public function index()
    {
        $idDepartamento=1;
        $existeDepartamento= Departamento::select('id','nombre')->get();
        if(!$existeDepartamento){
            return 'No existe';
        }else{
//            return Departamento::find(1)->empleados->load('resultados');
        }
        // De aqui, para arriba no borrar nunca
//        $empleados= Departamento::find($idDepartamento)->empleados;
//        $empleados= Departamento::with('empleados.resultados')->where('id',$idDepartamento)->get(); //XxX

        $encuestasDisponibles=Resultado::whereHas('empleado',function($query) use ($idDepartamento) {
            $query->where('departamento_id',$idDepartamento);
        })->distinct()->select('encuesta_id')->with('encuesta')->get();

//        return $encuestasDisponibles;
        $idDepartamento=1;
        $encuesta_id=2;
        $empleados= Departamento::with(['empleados.resultados' => function ($q) use ($encuesta_id) {
            $q->where('encuesta_id', $encuesta_id);
        }])->where('id',$idDepartamento)->select('id','nombre')->get();
//        return $empleados;

//        $empleados->with('resultados');
//        foreach($empleados as $empleado){
//            $empleado->resultados;
//        }
//        return $empleados;
//        return view('viewDePrueba');
        $departamentos= Departamento::all();
        return view('resultados',compact('departamentos','idDepartamento'));

    }

    public function select()
    {
//        return view('resultados');
        return view('selectDepartamentoResultados');
    }

    public function show($idDepartamento)
    {
        $idDepartamento=1;
        $existeDepartamento= Departamento::select('id','nombre')->get();
        if(!$existeDepartamento){
            return 'No existe';
        }else{
//            return Departamento::find(1)->empleados->load('resultados');
        }
        // De aqui, para arriba no borrar nunca
//        $empleados= Departamento::find($idDepartamento)->empleados;
//        $empleados= Departamento::with('empleados.resultados')->where('id',$idDepartamento)->get(); //XxX

        $encuestasDisponibles=Resultado::whereHas('empleado',function($query) use ($idDepartamento) {
            $query->where('departamento_id',$idDepartamento);
        })->distinct()->select('encuesta_id')->with('encuesta')->get();

//        return $encuestasDisponibles;

        $encuesta_id=1;
        $idDepartamento=1;
        $empleados= Departamento::with(['empleados.resultados' => function ($q) use ($encuesta_id) {
            $q->where('encuesta_id', $encuesta_id);
        }])->where('id',$idDepartamento)->get();
        return $empleados;

//        $empleados->with('resultados');
//        foreach($empleados as $empleado){
//            $empleado->resultados;
//        }
//        return $empleados;
//        return view('viewDePrueba');
        $departamentos= Departamento::all();
        return view('resultados',compact('departamentos','idDepartamento'));


    }
}
