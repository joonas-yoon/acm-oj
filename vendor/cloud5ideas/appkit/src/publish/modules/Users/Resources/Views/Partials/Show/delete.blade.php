{!! Form::open(['method' => 'DELETE', 'route' => ['users.destroy', $user->id]]) !!}
@include('users::partials.show.edit', ['user' => $user])
@include('users::partials.show.disable', ['user' => $user])
<button class="btn btn-danger" data-toggle="tooltip" data-placement="bottom" title="Delete" type="submit">
	<i class="fa fa-times"></i> Delete
</button>
{!! Form::close() !!}