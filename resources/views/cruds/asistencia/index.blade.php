@extends('adminlte::page')

@section('title', 'Asistencias')

@section('content')
    @livewire('asistencia.asistencia-lw')
@stop

@section('css')
    @livewireStyles
@stop

@section('js')
    @livewireScripts
@stop