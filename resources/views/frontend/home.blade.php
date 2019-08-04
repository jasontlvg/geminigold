@extends('layouts.encuesta')

@section('css-link')
    <link href="{{asset('css/empleadoIndex.css')}}" rel="stylesheet">
@endsection

@section('content')
    <div class="containerSurveys">
        <div class="main__title">
{{--            @if(empty($disp))--}}
{{--                <h2 class="main__title">No hay Encuestas Disponibles</h2>--}}
{{--            @else--}}
{{--                <h2 class="main__title">Encuestas Disponibles</h2>--}}
{{--            @endif--}}
        </div>
{{--        @empty($disp)--}}
{{--            <div class="container">--}}
{{--                <img class="ui large centered circular image" src="{{asset('img/11.jpg')}}" alt="">--}}
{{--            </div>--}}
{{--        @endempty--}}
        <div class="ui special cards">
            @foreach($contestar as $encuesta)
{{--                <h2>{{$encuesta->encuesta->nombre}}</h2>--}}
                <div class="card">
                    <div class="blurring dimmable image">
                        <div class="ui dimmer">
                            <div class="content">
                                <div class="center">
                                    <a class="ui inverted button contestar-boton" href="{{route('encuesta.show',$encuesta->encuesta->id)}}">Contestar</a>
                                </div>
                            </div>
                        </div>
                        <img src="/img/elliot.jpg" alt="">
                    </div>
                    <div class="content"><a class="header" href="#">{{$encuesta->encuesta->nombre}}</a>
                        <div class="meta">
                            <div class="date">Created in Sep 2014</div>
                        </div>
{{--                        <div class="description">Encuesta sobre las Personas del ambiente laboral</div>--}}
                    </div>
                    <a class="ui green button" href="#">¡Contestar!</a>
                </div>
            @endforeach
        </div>
    </div>
@endsection

@section('js-link')
    <script type="text/javascript" src="{{asset('js/empleadoIndex.js')}}"></script>
@endsection
