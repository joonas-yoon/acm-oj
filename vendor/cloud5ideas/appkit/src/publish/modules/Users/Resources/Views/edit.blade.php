@extends('shell::layouts.app')
@section('title')
    @parent
    Edit: {{$user->first_name}} {{$user->last_name}}
@stop

@section('breadcrumbs')
    @parent
    <a href="{{route('users.index')}}" class="btn btn-default">Users</a>
    <a href="#" class="btn btn-default">Edit: {{$user->first_name}} {{$user->last_name}}</a>
@stop

@section('content')
	<div class="panel panel-default">
		<div class="panel-heading">Edit Details</div>
		<div class="panel-body">
			{!! Form::model($user, ['method' => 'PATCH', 'route' => ['users.update', $user->id]]) !!}
				@include('users::partials.form.details')
				@if ($is_superuser && $user_id != $user->id)
					@include('users::partials.form.permissions')
				@endif
				{!! Form::submit('Update Details', ['class' => 'btn btn-primary']) !!}
			{!! Form::close() !!}
		</div>
	</div>
	@if($user_id == $user->id)
		<div class="panel panel-default">
			<div class="panel-heading">Edit Password</div>
			<div class="panel-body">
				{!! Form::open(['method' => 'PUT', 'route' => ['users.password', $user->id]]) !!}
					@include('users::partials.form.password')
					{!! Form::submit('Update Password', ['class' => 'btn btn-primary']) !!}
				{!! Form::close() !!}
			</div>
		</div>

		<div class="panel panel-default">
			<div class="panel-heading">Upload Photo</div>
			<div class="panel-body">
				{!! Form::open(['method' => 'PUT', 'route' => ['users.image', $user->id], 'files' => true]) !!}
					@include('users::partials.form.image')
					{!! Form::submit('Upload Photo', ['class' => 'btn btn-primary']) !!}
				{!! Form::close() !!}
			</div>
		</div>
	@endif
@endsection