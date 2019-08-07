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
        let xs='Jason';
        let chart='chart';
        var ctx = document.getElementById('myChart').getContext('2d');
        var myPieChart = new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: [''],
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

