<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Encuesta;
use Illuminate\Support\Facades\Auth;

class EncuestaController extends Controller
{
    public function show($id)
    {
//        $preguntas= EncuestaPregunta::where('encuesta_id',$id)->with('pregunta')->get();
        $preguntas=Encuesta::find($id)->preguntas;
//        return $preguntas;
        return view('frontend.encuesta');
    }

    public function store($id)
    {
        return $id;
    }
}
