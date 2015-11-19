@if ($this_user->can('edit.users'))
	<a href="{{route('users.edit', $user->id)}}" class="btn btn-primary">
		<i class="fa fa-pencil"></i> Edit
	</a>
@endif