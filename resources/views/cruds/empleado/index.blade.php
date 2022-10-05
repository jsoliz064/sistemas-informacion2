@extends('adminlte::page')

@section('title', 'Empleados')

@section('content')
    @livewire('empleado.empleado-lw')
@stop

@section('css')
    @livewireStyles
@stop

@section('js')
    @livewireScripts
@stop