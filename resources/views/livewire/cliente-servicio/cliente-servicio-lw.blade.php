<div>

    <head>
        <link rel="stylesheet" href="{{ asset('css/modal.css') }}">
        <link rel="stylesheet" href="{{ asset('css/tabla.css') }}">
    </head>
    <br>
    <div class="my-1">
        <h1 class="d-flex justify-content-center"><b>Servicios pendientes</b></h1>
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
                                <th scope="col">Cliente</th>
                                <th scope="col">Servicio</th>
                                @can('admin')
                                <th scope="col">Empleado</th>
                                @endcan
                                <th scope="col">Fecha de Solicitud</th>
                                <th scope="col">Estado</th>
                                <th scope="col">Terminado</th>
                                <th scope="col" width="30%">Acciones</th>
                            </tr>
                        </thead>

                        <tbody>

                            @foreach ($cliente_servicios as $cliente_servicio)
                                <tr>
                                    <td>{{ $cliente_servicio->id }}</td>
                                    <td>{{ $cliente_servicio->Cliente->name }}</td>
                                    <td>{{ $cliente_servicio->Servicio->name }}</td>
                                    @can('admin')
                                    <td> @if ($cliente_servicio->empleado_id) {{ $cliente_servicio->Empleado->name }} @else No Asignado @endif</td>
                                    @endcan
                                    <td>{{ $cliente_servicio->created_at }}</td>
                                    <td>@if ($cliente_servicio->accepted) Aceptado @else No Aceptado @endif </td>
                                    <td>@if ($cliente_servicio->finished) Terminado @else En ejecución @endif </td>
                                    <td class="d-flex justify-content-center">
                                        @can('empleado')
                                            <a class="btn btn-success btn-sm" href="{{route('solicitudes.show',$cliente_servicio)}}">Ver Detalle</a>
                                        @endcan
                                        @can('admin')
                                            <a class="btn btn-info btn-sm mx-2" wire:click="modalEdit('{{ $cliente_servicio->id }}')">Asignar Empleado</a>
                                            <button wire:click="modalDestroy('{{ $cliente_servicio->id }}')"
                                                class="btn btn-danger btn-sm"><i class="fas fa-trash-alt"></i></button>
                                        @endcan
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
    @if ($modalCrear)
        <div class="modald">
            <div class="modald-contenido">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="exampleModalLabel">Crear Servicio</h4>
                        </div>
                        <div class="modal-body">
                                <h5>Nombre:</h5>
                                <input type="text" wire:model="servicio.name" class="form-control">
                                @error('servicio.name')
                                    <small class="text-danger">Campo Requerido</small>
                                @enderror

                                

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" wire:click="cancelar()">Cancelar</button>
                            <button type="button" class="btn btn-primary" wire:click="store()">Guardar</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

    @if ($modalEdit)
        <div class="modald">
            <div class="modald-contenido">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="exampleModalLabel">Asignar tarea</h4>
                        </div>
                        <div class="modal-body">
                                <h5>Empleado:</h5>
                                <select wire:model="cliente_servicio.empleado_id" class="form-control" >
                                    <option value="">Seleccionar un empleado</option>
                                    @foreach ($empleados as $empleado)
                                        <option value="{{$empleado->id}}">{{$empleado->name}}</option>
                                    @endforeach
                                </select>
                                @error('cliente_servicio.empleado_id')
                                    <small class="text-danger">Campo Requerido</small>
                                @enderror
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" wire:click="cancelar()">Cancelar</button>
                            <button type="button" class="btn btn-primary" wire:click="update()">Actualizar</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

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


</div>
