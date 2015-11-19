<div class="form-group">
	<label for="cmbRole">Role</label>
	{!! Form::select('role', $roles, null, ['class' => 'form-control', 'placeholder' => 'Application Role']) !!}
</div>
@if ($is_superuser)
	<div class="checkbox">
		<label>
			{!! Form::checkbox('is_superuser', 1) !!} Superuser
		</label>
	</div>
@endif