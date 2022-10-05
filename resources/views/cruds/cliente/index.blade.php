@extends('adminlte::page')

@section('title', 'Clientes')

@section('content')
    @livewire('cliente.cliente-lw')
@stop

@section('css')
    @livewireStyles
@stop

@section('js')
    @livewireScripts
@stop