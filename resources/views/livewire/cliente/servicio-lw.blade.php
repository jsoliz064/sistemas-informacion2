<div>

    <head>
        <link rel="stylesheet" href="{{ asset('css/modal.css') }}">
        <link rel="stylesheet" href="{{ asset('css/tabla.css') }}">
    </head>
    <br>
    <div class="my-1">
        <h1 class="d-flex justify-content-center"><b>Solicitar Servicio</b></h1>
    </div>
    <div class="card">
        <div class="card-body">
            <h5>Servicio:</h5>
            <select wire:model="clienteservicio.servicio_id" class="form-control" >
                <option value="">Seleccione un servicio</option>
                @foreach ($servicios as $servicio)
                <option value="{{$servicio->id}}">{{$servicio->name}}</option>
                @endforeach
            </select>
            @error('clienteservicio.servicio_id')
            <small class="text-danger">Campo Requerido</small>
            @enderror 
            
            <h5>Ubicacion:</h5>
            <div class="fullwidth-sidebar-container">
                <div class="">
                    <div id="map-canvas" style="height: 250px; width: 100%; position: relative; overflow: hidden;">
                    </div>
                </div>
            </div>
            <input id="longitud" wire:model="clienteservicio.longitud" type="text">
            <input id="latitud" wire:model="clienteservicio.latitud" type="text">

            <a class="btn btn-primary btb-sm" wire:click="store()">Solicitar</a>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-sm-12 col-md-6">
                    <div class="dataTables_length" id="clientes_length">
                        <label>
                            Ver:
                            <select wire:model='cant' name="clientes_lenght" aria-controls="clientes"
                                class="form-control form-control-sm">
                                <option value="10">10</option>
                                <option value="25">25</option>
                                <option value="50">50</option>
                                <option value="100">100</option>
                            </select>
                            Ordenar:
                            <select wire:model='ordenar' name="clientes_lenght" aria-controls="clientes"
                                class="form-control form-control-sm">
                                <option value="asc">Ascendente</option>
                                <option value="desc">Descendente</option>
                            </select>
                        </label>
                    </div>
                </div>
            </div>
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
                                    <td>{{ $cliente_servicio->accepted }}</td>
                                    <td class="d-flex justify-content-center">
                                        <a class="btn btn-info btn-sm mx-2" wire:click="modalEdit('{{ $cliente_servicio->id }}')"><i class="fas fa-pen"></i></a>
                                        <button wire:click="modalDestroy('{{ $cliente_servicio->id }}')"
                                            class="btn btn-danger btn-sm"><i class="fas fa-trash-alt"></i></button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>

                    </table>
                </div>

            </div>
            <div class="row">
                <div class="col-sm-12 col-md-7">
                    <div class="dataTables_paginate paging_simple_numbers" id="clientes_paginate">
                        @if ($cliente_servicios->hasPages())
                            <div class="px-6 py-3">
                                {{ $cliente_servicios->links() }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>

        </div>
    </div>

    @if ($modalDestroy)
        <div class="modald">
            <div class="modald-contenido">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">

                        <div class="card-header">
                            <div class="d-flex align-items-center text-center justify-content-center">
                                <h5>¿Estás seguro?</h5>
                            </div>
                        </div>

                        <div class="modal-body">
                            <div align="center">
                                <button type="button" class="btn btn-secondary btn-sm my-2 mx-2"
                                    wire:click="cancelar()">Cancelar</button>
                                <button wire:click="destroy()"
                                    class="btn btn-danger btn-sm my-2 mx-2">Eliminar</button>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    @endif

    <script type='text/javascript' src='https://maps.google.com/maps/api/js?language=en&key=AIzaSyDoXPpQqlLk-R1-HEi-PpFLkSUoEhzGDY4&libraries=places&region=GB'></script>
    <script defer>
        const selected=document.getElementById('selected');
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
        let markers=[];
        function initialize() {
            let map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);
            let startLocation;

            google.maps.event.addListener(map, 'click', function(event) {
                deleteMarkers();
                mapZoom = map.getZoom();
                startLocation = event.latLng;
                document.getElementById('longitud').value=event.latLng.lng();
                document.getElementById('latitud').value=event.latLng.lat();
                setTimeout(placeMarker, 600);
            });
            
            function placeMarker() {
                if(mapZoom == map.getZoom()){
                    var marker=new google.maps.Marker({position: startLocation, map: map});
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
