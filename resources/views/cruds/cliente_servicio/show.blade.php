@extends('adminlte::page')

@section('title', 'Detalle Solicitud')

@section('content')
    
    <br>
    <div class="my-2">
        <h1 class="d-flex justify-content-center"><b><u>Detalle de Solicitud</u></b></h1>
    </div>
    <div class="card">
        <div class="card-body">
            <h5><b>Servicio:</b> {{$cliente_servicio->Servicio->name}}</h5>
            <h5><b>Cliente:</b> {{$cliente_servicio->Cliente->name}}</h5>
            <h5><b>Empleado designado:</b> @if ($cliente_servicio->empleado_id) {{$cliente_servicio->Empleado->name}} @endif</h5>
            <h5><b>Estado:</b> @if ($cliente_servicio->finished) Completado @else En proceso @endif</h5>
            <h5><b>Fecha de Solicitud:</b> {{$cliente_servicio->created_at}}</h5>
        </div>
    </div>

    <div class="fullwidth-sidebar-container">
        <div class="">
            <div id="map-canvas" style="height: 350px; width: 100%; position: relative; overflow: hidden; border-radius:1rem;">
            </div>
        </div>
    </div>
    @livewire('informe.informe-lw',['cliente_servicio_id'=>$cliente_servicio->id])
   

    <script type='text/javascript' src='https://maps.google.com/maps/api/js?language=en&key=AIzaSyDoXPpQqlLk-R1-HEi-PpFLkSUoEhzGDY4&libraries=places&region=GB'></script>
    <script defer>
        const selected=document.getElementById('selected');
        let markers=@json($markers);
        let mapOptions = {
            zoom: 12,
            minZoom: 8,
            maxZoom: 20,
            zoomControl:true,
            zoomControlOptions: {
                style:google.maps.ZoomControlStyle.DEFAULT
            },
            center: new google.maps.LatLng({{ $latitude }}, {{ $longitude }}),
            mapTypeId: google.maps.MapTypeId.ROADMAP,
            scrollwheel: true,
            panControl:false,
            mapTypeControl:false,
            scaleControl:false,
            overviewMapControl:false,
            rotateControl:false
        }

        function initialize() {
            var map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);
            //var image = new google.maps.MarkerImage("assets/images/pin.png", null, null, null, new google.maps.Size(40,52));
            var places = markers;

            for(place in places)
            {
                place = places[place];
                if(place.latitude && place.longitude)
                {
                    var marker = new google.maps.Marker({
                        position: new google.maps.LatLng(place.latitude, place.longitude),
                        //icon:(BitmapDescriptorFactory.defaultMarker(BitmapDescriptorFactory.HUE_AZURE)),
                        map: map,
                        title: place.name,
                    });
                    var infowindow = new google.maps.InfoWindow();
                    google.maps.event.addListener(marker, 'click', (function (marker, place) {
                        return function () {
                            infowindow.setContent(setContentMarker(place))
                            infowindow.open(map, marker);
                        }
                    })(marker, place));
                }
            }
        }
        google.maps.event.addDomListener(window, 'load', initialize);
    </script>
@stop

@section('css')
    @livewireStyles
@stop

@section('js')
    @livewireScripts
@stop