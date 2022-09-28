@extends('adminlte::page')

@section('title', 'Users')

@section('content_header')
    <h1>users:</h1>
    @foreach ($users as $user)
        <p>{{$user->name}}</p>
    @endforeach
@stop

@section('content')
    
@stop

@section('css')

@stop

@section('js')

@stop