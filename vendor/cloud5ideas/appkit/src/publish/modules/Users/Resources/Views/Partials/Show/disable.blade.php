@if( $user->isDisabled() )
	@if ($this_user->can('enable.users'))
		<a href="{{route('users.enable', $user->id)}}" class="btn btn-success">
			<i class="fa fa-check-circle-o"></i> Enable
		</a>
	@endif
@else
	@if ($this_user->can('disable.users'))
		<a href="{{route('users.disable', $user->id)}}" class="btn btn-warning">
			<i class="fa fa-ban"></i> Disable
		</a>
	@endif
@endif