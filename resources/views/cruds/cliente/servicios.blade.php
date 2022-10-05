@extends('adminlte::page')

@section('title', 'Clientes')

@section('content')
    <div>
        <br>
        <div class="my-1">
            <h1 class="d-flex justify-content-center"><b>Solicitar Servicio</b></h1>
        </div>
        <div class="d-flex justify-content-center my-2">
            <div class="px-4 py-3" style="height:450px; width:60%; background-color:rgb(64, 145, 250); border-radius: 2rem;">
                <form method="post" action="{{ route('cliente.servicio.store') }}" novalidate>
                    @csrf
                    <h5 class="my-2"style="color:white;">Servicio:</h5>
                    <select name="servicio_id" class="form-control">
                        <option value="">Seleccione un servicio</option>
                        @foreach ($servicios as $servicio)
                            <option value="{{ $servicio->id }}">{{ $servicio->name }}</option>
                        @endforeach
                    </select>
                    @error('servicio_id')
                        <small class="text-danger">Campo Requerido</small>
                    @enderror

                    <h5 class="my-2"style="color:white;">Ubicación:</h5>
                    <div class="fullwidth-sidebar-container">
                        <div class="">
                            <div id="map-canvas"
                                style="height: 220px; width: 100%; position: relative; overflow: hidden; border-radius: 1rem;">
                            </div>
                        </div>
                    </div>
                    <input id="longitud" name="longitud" style="display:none" type="text">
                    <input id="latitud" name="latitud" style="display:none" type="text">
                    <div align="center" class="my-4">
                        <button class="btn btn-primary btn-lg" style="background: white; color:rgb(0, 13, 71);"
                            type="submit">Solicitar</button>
                    </div>
                </form>
            </div>
        </div>

        <div class="card my-4">
            <div class="card-header">
                <h2 class="d-flex justify-content-center"><b>Mis Solicitudes</b></h2>
            </div>
            <div class="card-body">

                <div class="row">
                    <div class="table-responsive">

                        <table class="table table-striped" id="clientes">
                            <thead>
                                <tr>
                                    <th scope="col">ID</th>
                                    <th scope="col">Servicio</th>
                                    <th scope="col">Fecha de Solicitud</th>
                                    <th scope="col">Estado</th>
                                    <th scope="col" width="15%">Acciones</th>
                                </tr>
                            </thead>

                            <tbody>

                                @foreach ($cliente_servicios as $cliente_servicio)
                                    <tr>
                                        <td>{{ $cliente_servicio->id }}</td>
                                        <td>{{ $cliente_servicio->Servicio->name }}</td>
                                        <td>{{ $cliente_servicio->created_at }}</td>
                                        <td>@if ($cliente_servicio->accepted ) <p style="color:green;">Atendido</p> @else <p style="color:red;">En espera</p> @endif</td>
                                        <td class="d-flex justify-content-center">
                                            <form action="{{ route('cliente.servicio.destroy', $cliente_servicio) }}"
                                                method="post">
                                                @csrf
                                                @method('delete')
                                                <button class="btn btn-danger btn-sm"
                                                    onclick="return confirm('¿ESTA SEGURO DE  BORRAR?')"
                                                    value="Borrar">Cancelar solicitud</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <br>

        <script type='text/javascript'
            src='https://maps.google.com/maps/api/js?language=en&key=AIzaSyDoXPpQqlLk-R1-HEi-PpFLkSUoEhzGDY4&libraries=places&region=GB'>
        </script>
        <script defer>
            const selected = document.getElementById('selected');
            let mapOptions = {
                zoom: 12,
                minZoom: 8,
                maxZoom: 20,
                zoomControl: true,
                zoomControlOptions: {
                    style: google.maps.ZoomControlStyle.DEFAULT
                },
                center: new google.maps.LatLng({{ $latitude }}, {{ $longitude }}),
                mapTypeId: google.maps.MapTypeId.ROADMAP,
                scrollwheel: true,
                panControl: false,
                mapTypeControl: false,
                scaleControl: false,
                overviewMapControl: false,
                rotateControl: false
            }
            let markers = [];

            function initialize() {
                let map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);
                let startLocation;

                google.maps.event.addListener(map, 'click', function(event) {
                    deleteMarkers();
                    mapZoom = map.getZoom();
                    startLocation = event.latLng;
                    document.getElementById('longitud').value = event.latLng.lng();
                    document.getElementById('latitud').value = event.latLng.lat();
                    setTimeout(placeMarker, 600);
                });

                function placeMarker() {
                    if (mapZoom == map.getZoom()) {
                        var marker = new google.maps.Marker({
                            position: startLocation,
                            map: map
                        });
                        markers.push(marker)
                    }
                }

                // Sets the map on all markers in the array.
                function setMapOnAll(map) {
                    for (var i = 0; i < markers.length; i++) {
                        markers[i].setMap(map);
                    }
                }

                // Removes the markers from the map, but keeps them in the array.
                function clearMarkers() {
                    setMapOnAll(null);
                }

                // Deletes all markers in the array by removing references to them.
                function deleteMarkers() {
                    clearMarkers();
                    markers = [];
                }

            }

            google.maps.event.addDomListener(window, 'load', initialize);
        </script>
    </div>

@stop

@section('css')
    <link rel="stylesheet" href="{{ asset('css/modal.css') }}">
    <link rel="stylesheet" href="{{ asset('css/tabla.css') }}">
@stop

@section('js')

@stop
