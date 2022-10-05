@extends('adminlte::page')

@section('title', 'Roles')

@section('content')
    @livewire('user.rol-lw')
@stop

@section('css')
    @livewireStyles
@stop

@section('js')
    @livewireScripts
@stop