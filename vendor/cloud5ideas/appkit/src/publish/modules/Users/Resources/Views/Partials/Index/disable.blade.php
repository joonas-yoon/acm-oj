@if( $user->isDisabled() )
	@if ($can_enable_users)
		<a href="{{route('users.enable', $user->id)}}" 
			class="btn btn-success" data-toggle="tooltip" 
			data-placement="bottom" title="Enable">
			<i class="fa fa-check-circle-o"></i>
		</a>
	@endif
@else
	@if ($can_disable_users)
		<a href="{{route('users.disable', $user->id)}}" 
			class="btn btn-warning" data-toggle="tooltip" 
			data-placement="bottom" title="Disable">
			<i class="fa fa-ban"></i>
		</a>
	@endif
@endif