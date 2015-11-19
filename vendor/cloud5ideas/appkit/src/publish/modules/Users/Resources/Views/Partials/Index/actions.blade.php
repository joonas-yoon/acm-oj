@if ($user_id == $user->id)
	<div class="btn-group btn-group-xs" role="group">
		@include('users::partials.index.show', ['user' => $user])
		@include('users::partials.index.edit', ['user' => $user])
	</div>
@else
	@if ($can_delete_users)
		@include('users::partials.index.delete', ['user' => $user])
	@else
		<div class="btn-group btn-group-xs" role="group">
			@include('users::partials.index.edit', ['user' => $user])
			@include('users::partials.index.disable', ['user' => $user])
		</div>
	@endif
@endif