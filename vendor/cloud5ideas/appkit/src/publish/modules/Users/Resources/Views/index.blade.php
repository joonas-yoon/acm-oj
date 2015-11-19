@extends('shell::layouts.app')
@section('title')
    @parent
    Users
@stop

@section('breadcrumbs')
    @parent
    <a href="#" class="btn btn-default">Users</a>
@stop

@section('content')
    @include('users::partials.form.search')
	@include('users::partials.result.users', ['users' => $users])
	{!! $users->render() !!}
@endsection