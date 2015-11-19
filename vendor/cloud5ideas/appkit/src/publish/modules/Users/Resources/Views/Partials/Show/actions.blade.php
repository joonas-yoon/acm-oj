@if ($user_id == $user->id)
	<a href="{{route('users.edit', $user_id)}}" class="btn btn-primary">
		<i class="fa fa-pencil"></i> Edit
	</a>
@else
	@if ($this_user->can('delete.users'))
		@include('users::partials.show.delete', ['user' => $user])
	@else
		@include('users::partials.show.edit', ['user' => $user])
		@include('users::partials.show.disable', ['user' => $user])
	@endif
@endif