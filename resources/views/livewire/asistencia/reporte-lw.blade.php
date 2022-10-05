<div>

    <head>
        <link rel="stylesheet" href="{{ asset('css/modal.css') }}">
        <link rel="stylesheet" href="{{ asset('css/tabla.css') }}">
    </head>
    <br>
    <div class="my-4">
        <h1 class="d-flex justify-content-center"><b>Reporte de Asistencias</b></h1>
    </div>
    <div class="card">
        <div class="card-body">
            <div class="row text-center">
                <div class="col-sm-12 col-md-1">
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
                        </label>
                    </div>
                </div>

                <div class="col-sm-12 col-md-3">
                    <div class="dataTables_length" id="clientes_length">
                        <label>
                            Ordenar:
                            <select wire:model='ordenar' name="clientes_lenght" aria-controls="clientes"
                                class="form-control form-control-sm">
                                <option value="asc">Asc</option>
                                <option value="desc">Desc</option>
                            </select>
                        </label>
                    </div>
                </div>

                <div class="col-sm-12 col-md-4">
                    <div class="dataTables_length" id="clientes_length">
                        <label>
                            Filtrar por Empleado:
                            <select wire:model='empleado_id' name="clientes_lenght" aria-controls="clientes"
                                class="form-control form-control-sm">
                                <option value="">Todos</option>
                                @foreach ($empleados as $empleado) 
                                    <option value="{{$empleado->id}}">{{$empleado->name}}</option>
                                @endforeach
                            </select>
                        </label>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12 col-md-2 mx-2">
                    <div id="clientes_filter" class="dataTables_filter">
                        <label>
                            De:
                            <input class="form-control form-control-sm" wire:model="datein" type="date">
                        </label>
                    </div>
                </div>
                <div class="col-sm-12 col-md-2">
                    <div id="clientes_filter" class="dataTables_filter">
                        <label>
                            Hasta:
                            <input class="form-control form-control-sm" wire:model="dateout" type="date">
                        </label>
                    </div>
                </div>
            </div>
                
            <div class="row">
                <div class="table-responsive">

                    <table class="table table-striped" id="clientes">
                        <thead>
                            <tr style="text-align: center;">
                                <th scope="col">ID</th>
                                <th scope="col">Empleado</th>
                                <th scope="col">Fecha y Hora de Entrada</th>
                                <th scope="col">Fecha y Hora de Salida</th>
                                <th scope="col">Estado</th>
                            </tr>
                        </thead>

                        <tbody>

                            @foreach ($asistencias as $asistencia)
                                <tr style="text-align: center;">
                                    <td>{{ $asistencia->id }}</td>
                                    <td>
                                        @if ($asistencia->empleado_id)
                                            {{ $asistencia->Empleado->name }}
                                        @endif
                                    </td>
                                    <td>{{$asistencia->begin}}</td>
                                    <td>{{$asistencia->end}}</td>
                                    <td>@if ($asistencia->begin!=null) <p style="color:green">Presente</p> @else <p style="color:red;">Falta</p> @endif</td>
                                </tr>
                            @endforeach
                            
                        </tbody>

                    </table>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12 col-md-7">
                    <div class="dataTables_paginate paging_simple_numbers" id="clientes_paginate">
                        @if ($asistencias->hasPages())
                            <div class="px-6 py-3">
                                {{ $asistencias->links() }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>

        </div>
    </div>

    
</div>
