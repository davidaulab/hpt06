@extends('layouts.breweries')

@section('title', 'Cervezas')

@section('content')
    
<h1>Listado de cervezas</h1>

        @isset($msg)
            <x-message type="ERROR" :message="$msg">  
            </x-message>                
            @endisset


        
              
            
            @if( 
                (null !==  ($msg = Session::get('message'))) &&
                (null !==  ($code = Session::get('code'))) 
                )
                    <x-message :type="$code" :message="$msg">  
                    </x-message>                
            @endif

            <div id="listado" class="row d-flex justify-content-between">
                @foreach ($beers as $beer)
    
      
                    <x-card size="S" title="{{ $beer->name }}"> 
                        
                        <x-slot:content>
                            <p>
                            @for ($i = 0; $i < 5; $i++)
                            <img src="{{ asset('img/icono.png') }}" style="max-height: 1em; 
                            
                            @if ($i > ($beer->vol / 2) )
                                -webkit-filter: grayscale(100%);
                                filter: grayscale(100%);
                                opacity: 0.6;
                            @endif
                            ">
                            @endfor
                            </p>    
                        <p>{{ $beer->description }}</p>
                        </x-slot:content>
    

                        <x-slot:img>
                        @isset($beer->img)
                        {{ $beer->img }}     
                        @else
                         {{  asset('img/default.jpg') }}
                        @endisset
                        </x-slot:img>
                        
                        
                        <x-slot:insideButtons>
                            <a href="{{ route('beers.show', $beer->id) }}" class="btn btn-primary">Ver detalle</a>
                                             
                        </x-slot:insideButtons>
    
                    </x-card>
                @endforeach
                </div>
                <!-- div class="d-flex justify-content-center m-2">
                    {{ $beers->links() }}

                </div -->    
                <div class="d-flex justify-content-center m-2">
                   
                    @auth
                        <a href="{{ route ('beers.create')  }}" class="btn btn-primary">Nueva cerveza</a>
                    @endauth
                    
                </div>


<script>let ruta = '{{ route ('beer.scroll') }}'; </script>
@endsection