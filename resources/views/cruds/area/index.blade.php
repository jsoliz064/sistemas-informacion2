@extends('adminlte::page')

@section('title', 'Areas')

@section('content')
    @livewire('area.area-lw')
@stop

@section('css')
    @livewireStyles
@stop

@section('js')
    @livewireScripts
@stop