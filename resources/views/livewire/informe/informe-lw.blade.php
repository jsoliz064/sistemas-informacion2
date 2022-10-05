<div>

    <head>
        <link rel="stylesheet" href="{{ asset('css/modal.css') }}">
        <link rel="stylesheet" href="{{ asset('css/tabla.css') }}">
    </head>
    <br>
    <h1 class="d-flex justify-content-center"><b>Informes</b></h1>

    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-sm-12 col-md-2">
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
                <div class="col-sm-12 col-md-2">
                    <div class="dataTables_length" id="clientes_length">
                        <label>
                            Ordenar:
                            <select wire:model='ordenar' name="clientes_lenght" aria-controls="clientes"
                                class="form-control form-control-sm">
                                <option value="asc">Ascendente</option>
                                <option value="desc">Descendente</option>
                            </select>
                        </label>
                    </div>
                </div>
                <div class="col-sm-12 col-md-8 d-flex justify-content-end">
                    <div class="dataTables_length" id="clientes_length">
                        <a class="btn btn-primary btb-sm" wire:click="crear()">Subir Informe</a>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="table-responsive">

                    <table class="table table-striped" id="clientes">
                        <thead>
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">Descripcion</th>
                                <th scope="col">Fecha</th>
                                <th scope="col">Documento</th>
                                <th scope="col" width="20%">Acciones</th>
                            </tr>
                        </thead>

                        <tbody>

                            @foreach ($informes as $informe)
                                <tr>
                                    <td>{{ $informe->id }}</td>
                                    <td>{{ $informe->description }}</td>
                                    <td>{{ $informe->created_at }}</td>
                                    <td><a href="public{{ $informe->path }}">{{ $informe->path }}</a></td>
                                    <td>
                                        <button wire:click="modalDestroy('{{ $informe->id }}')"
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
                        @if ($informes->hasPages())
                            <div class="px-6 py-3">
                                {{ $informes->links() }}
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
                            <h4 class="modal-title" id="exampleModalLabel">Subir Archivo</h4>
                        </div>
                        <div class="modal-body">
                            <form enctype="multipart/form-data" method="post" action="{{ route('informe.store',$cliente_servicio) }}">
                                @csrf
                                <h5>Descripcion:</h5>
                                <input class="form-control" name="description" type="text">
                                @error('description')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                                <h5>Cargar archivo:</h5>
                                <input class="form-control" accept=".*" multiple type="file" name="archivo">
                                @error('archivo')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                                <br>
                                <div class="modal-footer">
                                    <button class="btn btn-primary" type="submit">Guardar</button>
                                    <button type="button" class="btn btn-secondary" wire:click="cancelar()">Cancelar</button>
                                </div>
                            </form>
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
<br>
</div>
