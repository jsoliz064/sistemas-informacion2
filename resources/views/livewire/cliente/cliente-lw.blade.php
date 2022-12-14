<div>

    <head>
        <link rel="stylesheet" href="{{ asset('css/modal.css') }}">
        <link rel="stylesheet" href="{{ asset('css/tabla.css') }}">
    </head>
    <br>
    <div class="my-1">
        <h1 class="d-flex justify-content-center"><b>Clientes</b></h1>
        <a class="btn btn-primary btb-sm" wire:click="crear()">Registrar Cliente</a>
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
                                <th scope="col">Telefono</th>
                                <th scope="col">Email</th>
                                <th scope="col" width="15%">Acciones</th>
                            </tr>
                        </thead>

                        <tbody>

                            @foreach ($clientes as $cliente)
                                <tr>
                                    <td>{{ $cliente->id }}</td>
                                    <td>{{ $cliente->name }}</td>
                                    <td>{{ $cliente->ci }}</td>
                                    <td>{{ $cliente->phone }}</td>
                                    <td>{{ $cliente->User->email }}</td>
                                    <td class="d-flex justify-content-center">
                                        <a class="btn btn-info btn-sm mx-2" wire:click="modalEdit('{{ $cliente->id }}')"><i class="fas fa-pen"></i></a>
                                        <button wire:click="modalDestroy('{{ $cliente->id }}')"
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
                        @if ($clientes->hasPages())
                            <div class="px-6 py-3">
                                {{ $clientes->links() }}
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
                            <h4 class="modal-title" id="exampleModalLabel">Crear Cliente</h4>
                        </div>
                        <div class="modal-body">
                                <h5>Nombre:</h5>
                                <input type="text" wire:model="user.name" class="form-control">
                                @error('user.name')
                                    <small class="text-danger">Campo Requerido</small>
                                @enderror

                                <h5>Carnet de Identidad:</h5>
                                <input type="text" wire:model="user.ci" class="form-control">
                                @error('user.ci')
                                    <small class="text-danger">Campo Requerido</small>
                                @enderror

                                <h5>Telefono:</h5>
                                <input type="text" wire:model="user.phone" class="form-control">
                                @error('user.phone')
                                    <small class="text-danger">Campo Requerido</small>
                                @enderror

                                <h5>Correo:</h5>
                                <input type="email" wire:model="email" class="form-control" >
                                @error('email')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror

                                <h5>Contrase??a:</h5>
                                <input type="password" wire:model="user.password" class="form-control" autocomplete="new-password">
                                @error('user.password')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror

                                <h5>Confirmar contrase??a:</h5>
                                <input type="password" wire:model="user.cpassword" class="form-control">

                                {{--  <h5>Rol:</h5>
                                <select wire:model="user.rol_id" class="form-control" >
                                    <option value="">Seleccione un rol</option>
                                    @foreach ($rols as $rol)
                                        <option value="{{$rol->id}}">{{$rol->name}}</option>
                                    @endforeach
                                </select>
                                @error('user.rol_id')
                                    <small class="text-danger">Campo Requerido</small>
                                @enderror  --}}


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
                            <h4 class="modal-title" id="exampleModalLabel">Editar Cliente</h4>
                        </div>
                        <div class="modal-body">
                            <h5>Nombre:</h5>
                                <input type="text" wire:model="user.name" class="form-control">
                                @error('user.name')
                                    <small class="text-danger">Campo Requerido</small>
                                @enderror

                                <h5>Carnet de Identidad:</h5>
                                <input type="text" wire:model="user.ci" class="form-control">
                                @error('user.ci')
                                    <small class="text-danger">Campo Requerido</small>
                                @enderror

                                <h5>Telefono:</h5>
                                <input type="text" wire:model="user.phone" class="form-control">
                                @error('user.phone')
                                    <small class="text-danger">Campo Requerido</small>
                                @enderror

                                <h5>Correo:</h5>
                                <input type="email" wire:model="email" class="form-control">
                                @error('email')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror

                                <h5>Cambiar contrase??a:</h5>
                                <input type="password" wire:model="user.password" class="form-control" autocomplete="new-password">
                                @error('user.password')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror

                                <h5>Confirmar contrase??a:</h5>
                                <input type="password" wire:model="user.cpassword" class="form-control" autocomplete="off">

                                {{--  <h5>Rol:</h5>
                                <select wire:model="user.rol_id" class="form-control" >
                                    <option value="">Seleccione un rol</option>
                                    @foreach ($rols as $rol)
                                        <option value="{{$rol->id}}">{{$rol->name}}</option>
                                    @endforeach
                                </select>
                                @error('user.rol_id')
                                    <small class="text-danger">Campo Requerido</small>
                                @enderror  --}}
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
