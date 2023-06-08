@extends('layouts.breweries')

@section('title', 'Formulario de contacto')

@section('content')
    <div class="d-flex justify-content-center row">
    <h1 class="text-center">Contacta con nosotros</h1>

    <x-card size="M" title="Por favor, indícanos cómo podemos ayudarte y nos pondremos en contacto contigo a la mayor brevedad posible">

        <x-slot:content>
            <form method="POST" action="{{ route ('contact.sent') }}"> 
                @csrf

                <div class="mb-3">
                <label for="name" class="form-label">Tu nombre</label>
                <input type="text" class="form-control" id="name" name="name" placeholder="Tu nombre">
              </div>
              <div class="mb-3">
                <label for="email" class="form-label">Tu email</label>
                <input type="email" class="form-control" id="email" name="email" placeholder="Tu email">
              </div>
              <div class="mb-3">
                <label for="suggest" class="form-label">Tu consulta</label>
                <textarea class="form-control" id="suggest" name="suggest" rows="3" placeholder="Tu sugerencia"></textarea>
              </div>
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