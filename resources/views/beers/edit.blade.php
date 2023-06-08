@extends('layouts.breweries')

@section('title', 'Modificar de cerveza')

@section('content')
    <div class="d-flex justify-content-center row">
    <h1 class="text-center">Modificar cerveza</h1>

    <x-card size="M" title="Indica la información de la cerveza">

        <x-slot:content>
            <form method="POST" action="{{ route ('beers.update', $beer) }}" enctype="multipart/form-data"> 
              @method('PUT')
                @csrf

              <div class="mb-3">
                <label for="name" class="form-label">Nombre de la cerveza</label>
                <input type="text" class="form-control" id="name" name="name" placeholder="¿Cómo se llama la cerveza?" value="{{ $beer->name }}">
              </div>
              <div class="mb-3">
                <label for="description" class="form-label">Descripción</label>
                <textarea class="form-control" id="description" name="description" rows="3" placeholder="¿Qué la hace especial?"> {{ $beer->description }}</textarea>
              </div>
              <div class="mb-3">
                <label for="vol" class="form-label">Grados de alcohol</label>
                <input type="number" class="form-control" id="vol" name="vol" placeholder="Grados"  value="{{ $beer->vol }}">
              </div>
              <div class="mb-3 d-flex col flex-wrap">
                <div class="col-lg-12"><label for="breweries" class="form-label">Cervecerías que la sirven</label></div>
                @foreach ($breweries as $brewery)
                <div class="col-lg-6">
                  <input class="form-check-input" type="checkbox" value="{{ $brewery->id }}" name="brewery[]" id="brewery_{{ $brewery->id }}"
                  @if ($beer->breweries->find ($brewery->id))
                   checked
                  @endif
                  >
                  <label class="form-check-label" for="brewery_{{ $brewery->id }}">
                    {{ $brewery->name }}
                  </label>
                </div>  
                @endforeach
              </div>
              <div class="mb-3">
                <label for="image" class="form-label">Imagen</label>
                <input type="file" class="form-control" id="image" name="image" placeholder="Indica una foto"  >
              </div>
              @isset($beer->img)
              <div class="mb-3" style="min-height: 300px; background: url('{{ $beer->img }}'); background-repeat: no-repeat; background-size: auto">
                <label for="image" class="form-label">Imagen actual</label>
                
              </div>
              @endisset
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