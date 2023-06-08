@extends('layouts.breweries')

@section('title', 'Detalle de cervecería')


@section('content')
<h1 class="text-center">Detalle de cervecerías</h1>
@isset($quote)
<div class="w-100 d-flex justify-content-center bg-white text-primary m-4 p-2">{{ $quote }}</div>    
@endisset


<div class="row d-flex justify-content-center">


    <x-card size="M" title="{{ $brewery->name }}"  map="YES">
        <x-slot:content>
            {{ $brewery->description }}
            @isset($brewery->user)
            <p class="text-primary">Sugerencia de {{ $brewery->user->name }}</p>  
            @endisset

            @if (count($brewery->beers) > 0)
                <hr>
                <p >Cervezas que sirve</p>
                @foreach ($brewery->beers as $beer)
                <a href="{{ route ('beers.show', $beer) }}" class="text-decoration-none">
                <span class="badge rounded-pill bg-warning text-dark">{{ $beer->name }}</span>   
                </a>             
                @endforeach
            @endif

            
        </x-slot:content>
        @isset($brewery->image)
        <x-slot:img>
        {{ $brewery->image }}     
        </x-slot:img>
        @endisset

        <x-slot:infButtons>
            
            <a href="{{ route('breweries') }}" class="btn btn-primary">Volver</a>
            @if ((Auth::check()) && ((Auth::user()->id == $brewery->creator) || (Auth::user()->level <= 10) ))
            
                            <a href="{{ route('brewery.edit', $brewery->id) }}" class="btn btn-warning">Modificar</a>

            <form method="POST" action="{{ route('brewery.destroy', $brewery->id) }}">
                @method('DELETE')
                @csrf
                <button type="submit" class="btn btn-danger">Borrar</button>
            </form>
            @endif


        </x-slot:infButtons>
    </x-card>


</div>
<script type="text/javascript">
    var map = L.map('map').setView([{{ $brewery->lat }} , {{ $brewery->long }}], 15);

    L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
    maxZoom: 19,
    attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
}).addTo(map);

var marker = L.marker([ {{ $brewery->lat }} , {{ $brewery->long }}]).addTo(map);
marker.bindPopup("{{ $brewery->name }}").openPopup();
</script>

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