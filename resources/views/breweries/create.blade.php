@extends('layouts.breweries')

@section('title', 'Alta de cervecería')

@section('content')
    <div class="d-flex justify-content-center row">
    <h1 class="text-center">Nueva cervecería</h1>

    <x-card size="M" title="Indica la información de la cervecería">

        <x-slot:content>
            <form method="POST" action="{{ route ('brewery.store') }}" enctype="multipart/form-data"> 
                @csrf

              <div class="mb-3">
                <label for="name" class="form-label">Nombre de la cervecería</label>
                <input type="text" class="form-control" id="name" name="name" placeholder="¿Cómo se llama la cervecería?" value="{{ old ('name') }}">
              </div>
              <div class="mb-3">
                <label for="description" class="form-label">Descripción</label>
                <textarea class="form-control" id="description" name="description" rows="3" placeholder="¿Qué la hace especial?"> {{ old ('description') }}</textarea>
              </div>
              <div class="mb-3 d-flex col flex-wrap">
                @foreach ($beers as $beer)
                <div class="form-check col-lg-4">
                  <input class="form-check-input" type="checkbox" value="{{ $beer->id }}" name="beer[]" id="beer_{{ $beer->id }}">
                  <label class="form-check-label" for="beer_{{ $beer->id }}">
                    {{ $beer->name }}
                  </label>
                </div>  
                
                @endforeach
              </div>
              
              <div class="mb-3">
                <label for="lat" class="form-label">Latitud</label>
                <input type="text" class="form-control" id="lat" name="lat" placeholder="¿Donde está?"  value="{{ old ('lat') }}">
              </div>
              <div class="mb-3">
                <label for="longitud" class="form-label">Longitud</label>
                <input type="text" class="form-control" id="long" name="long" placeholder="¿Donde está?"  value="{{ old ('long') }}">
              </div>
              <div class="mb-3">
                <label for="image" class="form-label">Imagen</label>
                <input type="file" class="form-control" id="image" name="image" placeholder="Indica una foto"  >
              </div>
              @if ($errors)
                
                <div class="mb-3 text-danger">
                    {{ $errors->first() }}    
                </div>
                
              @endif
              <div class="d-flex justify-content-center">
                <button type="submit" class="btn btn-success">Enviar</button>
            </div>
            </form>
            </x-slot:content>
        
    </x-card>
    @if( 
        (null !==  ($msg = Session::get('message'))) &&
        (null !==  ($code = Session::get('code'))) 
        )
            <x-message :type="$code" :message="$msg">  
            </x-message>                
    @endif


          

</div>

@endsection