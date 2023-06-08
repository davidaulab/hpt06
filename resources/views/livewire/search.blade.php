<div class="row">

   

@isset($msg)
            <x-message type="ERROR" :message="$msg">  
            </x-message>                
            @endisset

            
              <div id="map" class="mb-4"  wire:ignore></div> <!-- NEW -->
            
            @if( 
                (null !==  ($msg = Session::get('message'))) &&
                (null !==  ($code = Session::get('code'))) 
                )
                    <x-message :type="$code" :message="$msg">  
                    </x-message>                
            @endif

            @auth
            <a href="{{ route ('brewery.user', Auth::user() ) }}" class="btn btn-success">Ver mis aportaciones</a>
                
            @endauth
            <div class="row my-4 d-flex justify-content-center">
                <form method="post">
                 @csrf
                 <input type="text" placeholder="Qué cervecería quieres buscar" class="form-control" wire:model="searchTerm" >
                 <!-- button  class="btn btn-warning mx-2" wire:click="search">Buscar</button -->
                </form>
             </div>
    <div class="row d-flex justify-content-between w-100">
        <script type="text/javascript">


            var map = L.map('map').setView([39.9552833,-3.8628411], 6);
        
            L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
        }).addTo(map);
            var markers = []; //NEW
        </script>

        @foreach ($breweries as $brewery)


            <x-card size="S" title="{{ $brewery->name }}">
                
                <x-slot:content>
                    {{ $brewery->description }}
                    
                </x-slot:content>
                @isset($brewery->image)
                <x-slot:img>
                {{ $brewery->image }}     
                </x-slot:img>
                @endisset
                
                
                <x-slot:insideButtons>
                    <a href="{{ route('brewery', $brewery->id) }}" class="btn btn-primary">Ver detalle</a>
                    <a href="javascript:selBrewery ({{ $brewery->lat }} , {{ $brewery->long }})" 
                        class="btn btn-primary" onmouseover="mouseOver(this)">Ver en mapa</a>                      
                </x-slot:insideButtons>

            </x-card>
            <!-- new -->
            <input type="hidden" name="lat" value="{{  $brewery->lat  }}">
            <input type="hidden" name="long" value="{{  $brewery->long  }}">

        @endforeach
        </div>
<!-- NEW -->
<script>
    document.addEventListener("DOMContentLoaded", () => {
        Livewire.hook('message.sent', (message, component) => {
            markers = [];
            console.log ('inicializo');
        });
        Livewire.hook('element.updated', (el, component) => {
            loadMarkers ();
        });
        loadMarkers ();
    });
    function loadMarkers () {
         console.dir (markers);


        let lat = document.getElementsByName ('lat');
        let long = document.getElementsByName ('long');
        
        let i = 0;
        markers = [];
        while ((i < lat.length) && (i < long.length)) {
            var marker = L.marker([ parseFloat(lat[i].value), parseFloat(long[i].value)]).addTo(map);       
            i++;
        }
    }
</script>

        
    <div class="d-flex justify-content-center m-2">
       
        @auth
            <a href="{{ route ('brewery.create')  }}" class="btn btn-primary">Nueva cervecería</a>
        @endauth
        
    </div>

    

    <script>
    var circle = null;

    function selBrewery (long, lat) {
        if (circle) {
            circle.remove();
        }
        
        circle = L.circle([long, lat], {
            color: 'red',
            fillColor: '#f03',
            fillOpacity: 0.5,
            radius: 300
        }).addTo(map);

       map.setView([long, lat], 12);
    }
    function mouseOver(obj) {
        const popcorn = obj;
        let tooltip = document.querySelector('#objPopper');
        if (!tooltip) {
            document.getElementsByTagName('BODY')[0].innerHTML +='<div id="objPopper" class="tooltipX">Pincha para localizarlo</div>';
            tooltip = document.querySelector('#objPopper');
        }
        let aux = window.Popper.createPopper(popcorn, tooltip, {
        placement: 'bottom',
        });
        
    }
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            Livewire.hook('message.received', (message, component) => {
                console.dir (message);
                console.log ('otro');
                console.dir (component);
            })
            Livewire.hook('message.sent', (message, component) => {
                var markerList = [];
                map.eachLayer(function(layer) {
            
                    if (layer && (typeof layer === 'object') && (layer instanceof L.Marker) && 
                    (map.getBounds().contains(layer.getLatLng()))){
                        console.dir (layer);
                        layer.remove ();
                    }
                }); 
            });
         
        });
    </script>
</div>
