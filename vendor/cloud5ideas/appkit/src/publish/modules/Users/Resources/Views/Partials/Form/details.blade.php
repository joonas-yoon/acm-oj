<div class="form-group">
	<label for="txtFirsName">First name</label>
	{!! Form::text('first_name', null, ['class' => 'form-control', 'placeholder' => 'First Name']) !!}
</div>
<div class="form-group">
	<label for="txtLastName">Last name</label>
	{!! Form::text('last_name', null, ['class' => 'form-control', 'placeholder' => 'Last Name']) !!}
</div>
<div class="form-group">
	<label for="txtEmail">Email</label>
	{!! Form::email('email', null, ['class' => 'form-control', 'placeholder' => 'Email']) !!}
</div>