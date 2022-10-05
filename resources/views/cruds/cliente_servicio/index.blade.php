@extends('adminlte::page')

@section('title', 'Solicitudes')

@section('content')
    @livewire('cliente-servicio.cliente-servicio-lw')
@stop

@section('css')
    @livewireStyles
@stop

@section('js')
    @livewireScripts
@stop