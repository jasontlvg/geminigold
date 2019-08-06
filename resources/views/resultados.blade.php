@extends('layouts.admin')

@section('css-link')
    <link href="{{asset('css/resultados.css')}}" rel="stylesheet">
@endsection

@section('content')
    <div class="containerResultados">
        <div class="search">
            <select id="select">
                @foreach($departamentos as $departamento)
                    @if($departamento->id == $idDepartamento)
                        <option value="{{$departamento->id}}" selected="selected">{{$departamento->nombre}}</option>
                    @else
                        <option value="{{$departamento->id}}">{{$departamento->nombre}}</option>
                    @endif
                @endforeach
{{--                <option value="audi" selected="selected">Audi</option>--}}
            </select>
            <button id="getSelect">Buscar</button>
        </div>
        <div class="info">
            <canvas id="myChart"></canvas>
        </div>
    </div>
@endsection

@section('js-link')
    <script type="text/javascript" src="{{asset('js/resultados.js')}}"></script>
    <script>
        var ctx = document.getElementById('myChart').getContext('2d');
        var myPieChart = new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: ['El equipo encargado de los cambios de modelo cuenta con habilidades y experiencia profesional', 'Existe una cultura organizacional hacia la mejora continua de procesos y del desarrollo y satisfacción de los miembros de la empresa', 'Todos los involucrados en la implementación de los cambios rápidos conocen el proceso', 'El personal encargado de realizar las actividades está comprometido y entiende de manera clara la importancia de realizar la actividad en el menor tiempo', 'Las personas encargadas de realizar los cambios rápidos conocen el funcionamiento y mantenimiento de la máquina y/o equipo', 'Las personas involucradas en implementar los cambios rápidos cuentan con un programa de capacitación y entrenamiento para trabajar el equipo y uso de herramientas', 'Existe un compromiso de la alta gerencia para involucrarse y comprometerse en las mejora de las actividades de cambios rápidos'],
                datasets: [{
                    label: 'My First dataset',
                    backgroundColor: 'rgb(255, 99, 132)',
                    borderColor: 'rgb(255, 99, 132)',
                    data: [0, 10, 5, 2, 20, 30, 45]
                }]
            },
            options: {}
        });
    </script>
@endsection

