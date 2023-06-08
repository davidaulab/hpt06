@extends('layouts.breweries')
  
@section('title', 'Listado de cervecerías')

@section('content')
           
    <h1 class="text-center">Listado de cervecerías</h1>

    <livewire:search />


       
            
            
@endsection



@section('aditionalheader')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.3/dist/leaflet.css"
     integrity="sha256-kLaT2GOSpHechhsozzB+flnD+zUyjE2LlfWPgU04xyI="
     crossorigin=""/>

     <!-- Make sure you put this AFTER Leaflet's CSS -->
<script src="https://unpkg.com/leaflet@1.9.3/dist/leaflet.js"
    integrity="sha256-WBkoXOwTeyKclOHuWtc+i2uENFpDZ9YPdf5Hf+D7ewM="
    crossorigin=""></script>

@endsection
        
    