@extends('layouts.breweries')

@section('title', 'Home')

@section('content')

@if(isset ($nombre) && isset($apellidos))

    Hola {{ $nombre . ' - ' . $apellidos }} con Blade <br>

@endif




<a href="/bienvenido">Ir a Welcome</a><br>
<a href="{{ url ('/bienvenido') }}">Ir a Welcome</a><br>

<a href="{{ route ('welcomepage') }}">Ir a Welcome</a><br>

@yield('contact')

@endsection
