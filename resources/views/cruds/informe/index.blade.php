@extends('adminlte::page')

@section('title', 'Informes')

@section('content')
    @livewire('informe.informe-lw')
@stop

@section('css')
    @livewireStyles
@stop

@section('js')
    @livewireScripts
@stop