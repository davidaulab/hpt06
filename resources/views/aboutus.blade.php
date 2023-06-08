@extends('layouts.breweries')

@section('title', 'Quienes somos')

@section('content')
<h1> Quienes somos </h1>
<p>Somos un portal de cervecerías independiente basado en las opiniones de clientes reales.</p>
<x-card size="L" title="Donde estamos" content="Carretera de pozuelo, 100. Majadahonda" map="YES">
</x-card>


<script type="text/javascript">
    var map = L.map('map').setView([40.4552833,-3.8628411], 13);

    L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
    maxZoom: 19,
    attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
}).addTo(map);

var marker = L.marker([40.4552833,-3.8628411]).addTo(map);
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
