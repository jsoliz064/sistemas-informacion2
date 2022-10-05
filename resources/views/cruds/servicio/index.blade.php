@extends('adminlte::page')

@section('title', 'Servicios')

@section('content')
    @livewire('servicio.servicio-lw')
@stop

@section('css')
    @livewireStyles
@stop

@section('js')
    @livewireScripts
@stop