@extends('layouts.admin')

@section('css-link')
    <link href="{{asset('css/empleados.css')}}" rel="stylesheet">
@endsection

@section('content')
    <div class="resultadosContainer">
        <select>
            @foreach($departamentos as $departamento)
                <option value="volvo">{{$departamento->nombre}}</option>
            @endforeach
        </select>
    </div>
@endsection
