@extends('layouts.breweries')

@section('title', 'Detalle de cerveza')


@section('content')
<h1 class="text-center">Detalle de cerveza</h1>
<div class="row d-flex justify-content-center">


    <x-card size="M" title="{{ $beer->name }}">
         <x-slot:content>{{ $beer->description }}
         @isset($amount)
             <p>
                Precio de la cerveza: {{ $amount }} €<br>
                <hr>
                @foreach ($rates as $key => $rate) 
                <span class="badge rounded-pill bg-success">
                    {{ $key . '  ' .  number_format($rate ,2, ",", ".")  }} </span> <br>
                @endforeach
             </p>
         @endisset

         @if (count($beer->breweries) > 0)
         <hr>
         <p>Cervecerías que la sirven</p>
         @foreach ($beer->breweries as $brewery)
         <a href="{{ route ('brewery', $brewery) }}" class="text-decoration-none">
            <span class="badge rounded-pill bg-primary text-decoration-none" >
            {{ $brewery->name }}
        </span></a>
             
         @endforeach
         @endif
         </x-slot:content>
            
        <x-slot:img>
            @isset($beer->img)
            {{ $beer->img }}     
            @else
            {{ asset('img/default.jpg') }}
            @endisset
        </x-slot:img>
        
        <x-slot:infButtons>
            
            <a href="{{ route('beers.index') }}" class="btn btn-primary">Volver</a>
            @auth
                @if ((Auth::user()->id == $beer->user_id) || (Auth::user()->level <= 10) )
                    <a href="{{ route('beers.edit', $beer->id) }}" class="btn btn-warning">Modificar</a>

                    <form method="POST" action="{{ route('beers.destroy', $beer->id) }}">
                        @method('DELETE')
                        @csrf
                        <button type="submit" class="btn btn-danger">Borrar</button>
                    </form>
                @endif
            @endauth



        </x-slot:infButtons>
    </x-card>


</div>
    

@endsection

