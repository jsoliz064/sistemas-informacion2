<div>

    <head>
        <link rel="stylesheet" href="{{ asset('css/modal.css') }}">
        <link rel="stylesheet" href="{{ asset('css/tabla.css') }}">
    </head>
    <br>
    <div class="my-1">
        <h1 class="d-flex justify-content-center"><b>Lista de Pagos</b></h1>
        @can('admin')
        <a class="btn btn-primary btb-sm" wire:click="crear()">Registrar Pago</a>
        @endcan
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
                                <th scope="col">Descripcion</th>
                                <th scope="col">Sueldo</th>
                                <th scope="col">Bono</th>
                                <th scope="col">Descuento</th>
                                <th scope="col">Total</th>
                                <th scope="col">Fecha</th>
                                @can('admin')
                                    <th scope="col">Empleado</th>
                                    <th scope="col" width="15%">Acciones</th>
                                @endcan
                            </tr>
                        </thead>

                        <tbody>

                            @foreach ($pagos as $pago)
                                <tr>
                                    <td>{{ $pago->id }}</td>
                                    <td>{{ $pago->description }}</td>
                                    <td>{{ $pago->amount }}</td>
                                    <td>{{ $pago->bonoamount }}</td>
                                    <td>{{ $pago->descuentoamount }}</td>
                                    <td>{{ $pago->total }}</td>
                                    <td>{{ $pago->created_at }}</td>
                                    @can('admin')
                                        <td>{{ $pago->Empleado->name }}</td>
                                        <td class="d-flex justify-content-center">
                                            <a class="btn btn-info btn-sm mx-2" wire:click="modalEdit('{{ $pago->id }}')"><i class="fas fa-pen"></i></a>
                                            <button wire:click="modalDestroy('{{ $pago->id }}')"
                                                class="btn btn-danger btn-sm"><i class="fas fa-trash-alt"></i></button>
                                        </td>
                                    @endcan
                                </tr>
                            @endforeach
                        </tbody>

                    </table>
                </div>

            </div>
            <div class="row">
                <div class="col-sm-12 col-md-7">
                    <div class="dataTables_paginate paging_simple_numbers" id="clientes_paginate">
                        @if ($pagos->hasPages())
                            <div class="px-6 py-3">
                                {{ $pagos->links() }}
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
                            <h4 class="modal-title" id="exampleModalLabel">Registrar pago</h4>
                        </div>
                        <div class="modal-body">
                                <h5>Descripcion:</h5>
                                <input type="text" wire:model="pago.description" class="form-control">
                                @error('pago.description')
                                    <small class="text-danger">Campo Requerido</small>
                                @enderror

                                <h5>Monto:</h5>
                                <input type="number" wire:model="pago.amount" class="form-control">
                                @error('pago.amount')
                                    <small class="text-danger">Campo Requerido</small>
                                @enderror


                                <h5>Empleado:</h5>
                                <select wire:model="pago.empleado_id" class="form-control" >
                                    <option value="">Seleccione un empleado</option>
                                    @foreach ($empleados as $empleado)
                                        <option value="{{$empleado->id}}">{{$empleado->name}}</option>
                                    @endforeach
                                </select>
                                @error('pago.empleado_id')
                                    <small class="text-danger">Campo Requerido</small>
                                @enderror

                                <button class="btn" wire:click="bono()"><i class="fas fa-plus"></i>Agregar Bono</button>
                                @if ($this->bono)
                                    <h5>Descripcion del bono:</h5>
                                    <input type="text" wire:model="pago.bono" class="form-control">
                                    @error('pago.bono')
                                        <small class="text-danger">Campo Requerido</small>
                                    @enderror

                                    <h5>Monto:</h5>
                                    <input type="number" wire:model="pago.bonoamount" class="form-control">
                                    @error('pago.bonoamount')
                                        <small class="text-danger">Campo Requerido</small>
                                    @enderror
                                @endif
                                <button class="btn" wire:click="descuento()"><i class="fas fa-plus"></i>Agregar Descuento</button>
                                @if ($this->descuento)
                                    <h5>Descripcion del descuento:</h5>
                                    <input type="text" wire:model="pago.descuento" class="form-control">
                                    @error('pago.descuento')
                                        <small class="text-danger">Campo Requerido</small>
                                    @enderror

                                    <h5>Monto:</h5>
                                    <input type="number" wire:model="pago.descuentoamount" class="form-control">
                                    @error('pago.descuentoamount')
                                        <small class="text-danger">Campo Requerido</small>
                                    @enderror
                                @endif


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
                            <h4 class="modal-title" id="exampleModalLabel">Editar Pago</h4>
                        </div>
                        <div class="modal-body">
                            <h5>Descripcion:</h5>
                                <input type="text" wire:model="pago.description" class="form-control">
                                @error('pago.description')
                                    <small class="text-danger">Campo Requerido</small>
                                @enderror

                                <h5>Monto:</h5>
                                <input type="number" wire:model="pago.amount" class="form-control">
                                @error('pago.amount')
                                    <small class="text-danger">Campo Requerido</small>
                                @enderror


                                <h5>Empleado:</h5>
                                <select wire:model="pago.empleado_id" class="form-control" >
                                    @foreach ($empleados as $empleado)
                                    <option value="{{$empleado->id}}">{{$empleado->name}}</option>
                                @endforeach
                                </select>
                                @error('pago.empleado_id')
                                    <small class="text-danger">Campo Requerido</small>
                                @enderror

                                <h5>Descripcion del bono:</h5>
                                <input type="text" wire:model="pago.bono" class="form-control">
                                @error('pago.bono')
                                    <small class="text-danger">Campo Requerido</small>
                                @enderror

                                <h5>Monto:</h5>
                                <input type="number" wire:model="pago.bonoamount" class="form-control">
                                @error('pago.bonoamount')
                                    <small class="text-danger">Campo Requerido</small>
                                @enderror
                             
                                <h5>Descripcion del descuento:</h5>
                                <input type="text" wire:model="pago.descuento" class="form-control">
                                @error('pago.descuento')
                                    <small class="text-danger">Campo Requerido</small>
                                @enderror

                                <h5>Monto:</h5>
                                <input type="number" wire:model="pago.descuentoamount" class="form-control">
                                @error('pago.descuentoamount')
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
