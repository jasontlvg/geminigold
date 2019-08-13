@extends('layouts.admin')

@section('css-link')
    <link href="{{asset('css/resultados.css')}}" rel="stylesheet">
@endsection

@section('content')
{{--    <img src="/img/exia.jpg" alt="">--}}
    <div id="app">

    </div>
@endsection

@section('js-link')
    <script src="{{asset('js/resultados.js')}}"></script>
    <script>
        let x='./';
        console.log(x);
    </script>
@endsection

