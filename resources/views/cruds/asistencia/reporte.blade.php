@extends('adminlte::page')

@section('title', 'Asistencias')

@section('content')
    @livewire('asistencia.reporte-lw')
@stop

@section('css')
    @livewireStyles
@stop

@section('js')
    @livewireScripts
@stop