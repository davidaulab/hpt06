@if ($size == 'L')
<div class="col col-12">
@elseif ($size == 'M') 
    <div class="col col-sm-6">
@else
<div class="col col-sm-4">
@endif 
    <div class="card mb-4 w-100 bg-lightyellow" >
       
       
        @isset ($img)
        <img src="{{ $img }}" class="card-img-top" alt="{{ $title }}">
        @endisset
        
        <div class="card-body">
            <h5 class="card-title text-primary"> {{ $title }}</h5>
            <p class="card-text">{!!  $content  !!}</p>
            @isset($insideButtons)
            <div class="col d-flex justify-content-between">
                {!! $insideButtons !!}
            </div>
            @endisset

        </div>
        @isset ($map)
        <div id="map" style="max-height:200px !important"></div>
        @endisset

    </div>
    @isset ($infButtons)
    <div class="d-flex justify-content-around mb-4">
     {{ $infButtons }}
    </div>
    @endisset
</div>