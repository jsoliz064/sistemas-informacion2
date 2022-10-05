@extends('adminlte::page')

@section('title', 'Usuarios')

@section('content')
    @livewire('user.user-lw')
@stop

@section('css')
    @livewireStyles
@stop

@section('js')
    @livewireScripts
@stop