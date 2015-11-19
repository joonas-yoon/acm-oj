{!! Form::open(['method' => 'DELETE', 'route' => ['users.destroy', $user->id]]) !!}
	<div class="btn-group btn-group-xs" role="group">
	@include('users::partials.index.show', ['user' => $user])
	@include('users::partials.index.edit', ['user' => $user])
	@include('users::partials.index.disable', ['user' => $user])
	<button class="btn btn-danger" data-toggle="tooltip" data-placement="bottom" title="Delete" type="submit">
		<i class="fa fa-times"></i>
	</button>
</div>
{!! Form::close() !!}