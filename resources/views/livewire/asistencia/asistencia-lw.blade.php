<div>

    <head>
        <link rel="stylesheet" href="{{ asset('css/modal.css') }}">
        <link rel="stylesheet" href="{{ asset('css/tabla.css') }}">
    </head>
    <br>
    <div class="my-1">
        <h1 class="d-flex justify-content-center"><b>Asistencia para Empleados</b></h1>
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
                                <th scope="col">CI</th>
                                <th scope="col" width="15%">Acciones</th>
                            </tr>
                        </thead>

                        <tbody>

                            @foreach ($empleados as $empleado)
                                <tr>
                                    <td>{{ $empleado->id }}</td>
                                    <td>{{ $empleado->name }}</td>
                                    <td>{{ $empleado->ci }}</td>
                                    <td class="d-flex justify-content-center">
                                        @if ($this->verificar($empleado->id)==1)
                                        <button wire:click="empezar('{{ $empleado->id }}')"
                                            class="btn btn-success btn-sm">Marcar Entrada</button>
                                        @endif
                                        @if ($this->verificar($empleado->id)==2)
                                        <button wire:click="terminar('{{ $empleado->id }}')"
                                            class="btn btn-danger btn-sm">Marcar Salida</button>
                                        @endif
                                        @if ($this->verificar($empleado->id)==3)
                                            <p>Jornada terminada</p>
                                        @endif
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
                        @if ($empleados->hasPages())
                            <div class="px-6 py-3">
                                {{ $empleados->links() }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>

        </div>
    </div>
    
</div>
