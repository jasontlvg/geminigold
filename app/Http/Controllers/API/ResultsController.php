<?php

namespace App\Http\Controllers\API;

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
//        if($request->get('departamento') == 2){
//            return 'Exito';
//        }else{
//            return 'Nada';
//        }
//        return $request->input('message');
        $encuesta_id=$request->get('encuesta');
        $idDepartamento=$request->get('departamento');
        $empleados= Departamento::with(['empleados.resultados' => function ($q) use ($encuesta_id) {
            $q->where('encuesta_id', $encuesta_id);
        }])->where('id',$idDepartamento)->select('id','nombre')->get();
        return $empleados;
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
