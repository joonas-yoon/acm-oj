@extends('shell::layouts.app')
@section('title')
    @parent
    Create User
@stop

@section('breadcrumbs')
    @parent
    <a href="{{route('users.index')}}" class="btn btn-default">Users</a>
    <a href="#" class="btn btn-default">Create User</a>
@stop

@section('content')
	<div class="panel panel-default">
	  <div class="panel-body">
	    {!! Form::open(['route' => 'users.store']) !!}
			@include('users::partials.form.details')
			@include('users::partials.form.password')
			@if ($is_superuser)
				@include('users::partials.form.permissions')
			@endif
			{!! Form::submit('Save User', ['class' => 'btn btn-primary']) !!}
	    {!! Form::close() !!}
	  </div>
	</div>
@endsection