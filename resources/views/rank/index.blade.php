@extends('master')

@section('content')
    @foreach( $users as $user )
        {{ $user->name }}<br/>
    @endforeach
@stop

@section('script')

@stop