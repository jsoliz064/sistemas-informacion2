<div>

    <head>
        <link rel="stylesheet" href="{{ asset('css/modal.css') }}">
        <link rel="stylesheet" href="{{ asset('css/tabla.css') }}">
    </head>
    <br>
    <div class="my-1">
        <h1 class="d-flex justify-content-center"><b>Servicios</b></h1>
        <a class="btn btn-primary btb-sm" wire:click="crear()">Registrar Servicio</a>
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
                <div class="col-sm-12 col-md-6">
                    <div id="clientes_filter" class="dataTables_filter">
                        <label>
                            Buscar:
                            <input placeholder="Nombre" wire:model="search" type="search"
                                class="form-control form-control-sm">
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
                                <th scope="col">Nombre</th>
                                <th scope="col">Area</th>
                                <th scope="col" width="15%">Acciones</th>
                            </tr>
                        </thead>

                        <tbody>

                            @foreach ($servicios as $servicio)
                                <tr>
                                    <td>{{ $servicio->id }}</td>
                                    <td>{{ $servicio->name }}</td>
                                    <td>{{ $servicio->Area->name }}</td>
                                    <td class="d-flex justify-content-center">
                                        <a class="btn btn-info btn-sm mx-2" wire:click="modalEdit('{{ $servicio->id }}')"><i class="fas fa-pen"></i></a>
                                        <button wire:click="modalDestroy('{{ $servicio->id }}')"
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
                        @if ($servicios->hasPages())
                            <div class="px-6 py-3">
                                {{ $servicios->links() }}
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

                                <h5>Area:</h5>
                                <select wire:model="servicio.area_id" class="form-control" >
                                    <option value="">Seleccione un area</option>
                                    @foreach ($areas as $area)
                                        <option value="{{$area->id}}">{{$area->name}}</option>
                                    @endforeach
                                </select>
                                @error('servicio.area_id')
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
                            <h4 class="modal-title" id="exampleModalLabel">Editar Servicio</h4>
                        </div>
                        <div class="modal-body">
                            <h5>Nombre:</h5>
                                <input type="text" wire:model="servicio.name" class="form-control">
                                @error('servicio.name')
                                    <small class="text-danger">Campo Requerido</small>
                                @enderror

                                <h5>Rol:</h5>
                                <select wire:model="servicio.area_id" class="form-control" >
                                    @foreach ($areas as $area)
                                        <option value="{{$area->id}}">{{$area->name}}</option>
                                    @endforeach
                                </select>
                                @error('servicio.area_id')
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
                                <h5>??Est??s seguro?</h5>
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
