@extends('adminlte::page')

@section('title', 'Users')

@section('content')
    @livewire('user.user-lw')
@stop

@section('css')
    @livewireStyles
@stop

@section('js')
    @livewireScripts
@stop