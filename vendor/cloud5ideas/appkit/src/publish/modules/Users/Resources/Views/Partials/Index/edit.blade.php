@if ($can_edit_users || $user_id == $user->id)
	<a href="{{route('users.edit', $user->id)}}" 
		class="btn btn-primary" data-toggle="tooltip" 
		data-placement="bottom" title="Edit">
		<i class="fa fa-pencil"></i>
	</a>
@endif