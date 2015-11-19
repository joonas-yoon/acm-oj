@extends('shell::layouts.app')
@section('title')
    @parent
    User Search
@stop

@section('breadcrumbs')
    @parent
    <a href="{{route('users.index')}}" class="btn btn-default">Users</a>
    <a href="#" class="btn btn-default">Search</a>
@stop

@section('content')
    @include('users::partials.form.search')
	@include('users::partials.result.users', ['users' => $users])
@endsection