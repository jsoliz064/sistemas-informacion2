@extends('adminlte::page')

@section('title', 'Pagos')

@section('content')
    @livewire('pago.pago-lw')
@stop

@section('css')
    @livewireStyles
@stop

@section('js')
    @livewireScripts
@stop