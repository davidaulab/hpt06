<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title')</title>
    <!-- link rel="stylesheet" href="./css/app.css"-->
  
    <!--
      link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
-->

    @vite(['resources/sass/app.scss', 'resources/css/app.css', 'resources/js/app.js', 'resources/js/miApp.js'])
    @yield('aditionalheader')

    @livewireStyles 
</head>

<body class="vh-100">
    <div class="container">

   <header class="bg-warning">
    
    <nav class="navbar navbar-expand-lg bg-light">
        <div class="container-fluid">
          <a class="navbar-brand" href="{{ route('home') }}"><img src="{{ asset('img/icono.png') }}" style="max-height: 40px"></a>
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
              <li class="nav-item">
                <a class="nav-link" href="{{ route ('breweries') }}">Cervecerías</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="{{ route ('beers.index') }}">Cervezas</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="{{ route ('contact') }}">Contacto</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="{{ route ('aboutus') }}">Quienes somos</a>
              </li>
            </ul>
          </div>
          <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <!-- Left Side Of Navbar -->
            <ul class="navbar-nav me-auto">

            </ul>

            <!-- Right Side Of Navbar -->
            <ul class="navbar-nav ms-auto">
                <!-- Authentication Links -->
               
                @guest
                    @if (Route::has('login'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">{{ __('Iniciar sesión') }}</a>
                        </li>
                    @endif

                    @if (Route::has('register'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}">{{ __('Nuevo usuario') }}</a>
                        </li>
                    @endif
                @else
                    <li class="nav-item dropdown">
                      <a class="dropdown-item" href="{{ route('logout') }}"
                      onclick="event.preventDefault();
                                    document.getElementById('logout-form').submit();">
                       {{ __('No soy ' ) . Auth::user()->name }}
                     </a>

                       
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                       
                    </li>
                @endguest
            </ul>
        </div>
        </div>
      </nav>
    
   </header> 
        <div>
            @yield('content')
        </div>

    </div>
    
    <footer class="w-100" style="bottom:0px">
        <div class="container bg-secondary text-white">
        Pie de página<br>1<br>2
<br>3        </div>
    </footer>
<!-- script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
-->
<script src="https://code.jquery.com/jquery-3.6.4.js" integrity="sha256-a9jBBRygX1Bh5lt8GZjXDzyOB+bWve9EiO7tROUtj/E=" crossorigin="anonymous"></script>
<script>
  let finListado = false;
  window.pagina = 1;
  
  function getData () {
   
          
      window.pagina++;
      $.ajax ({
          url: ruta + '?page=' + window.pagina,
          type: 'get',
          beforeSend : function () {
            console.log ('solicitando nueva página');
          }

      })
      .done (function (data) {
        if (data != '') {
            $('#listado').append (data);
      
        }
        else {
          if (finListado == false) {
            $('#listado').append ('<p class="text-danger">No hay más elementos para mostrar</p>');
            finListado = true;
          }
        
        }
      })
      .fail (function (jqXHR, ajaxOption, error){
          console.log ('Error en la petición');
      }); 
    
  }

  $(window).scroll (function () {
    if (($(window).scrollTop() + $(window).height () )  >=  $('#listado').scrollTop ())  {
      if (finListado == false) {
        getData ();
      }
    }
  });
  </script>
  @livewireScripts 
</body>

</html>
