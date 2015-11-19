@extends('auth::layouts.auth')

@section('title')
    @parent
    Register
@stop

@section('content')

    {!! Form::open()!!}
            <div class="form-group">
                {!! Form::text('first_name', old('first_name'), ['class' => 'form-control', 'placeholder' => 'First Name']) !!}
            </div>
            <div class="form-group">
                {!! Form::text('last_name', old('last_name'), ['class' => 'form-control', 'placeholder' => 'Last Name']) !!}
            </div>
            <div class="form-group">
                {!! Form::email('email', old('email'), ['class' => 'form-control', 'placeholder' => 'E-mail']) !!}
            </div>
            <div class="form-group">
                {!! Form::password('password', ['class' => 'form-control', 'placeholder' => 'Password']) !!}
            </div>
            <div class="form-group">
                {!! Form::password('password_confirmation', ['class' => 'form-control', 'placeholder' => 'Confirm Password']) !!}
            </div>
            {!! Form::submit('Register', ['class' => 'btn btn-primary btn-block']) !!}
            {!! Html::link(url('/auth/login'), 'Login') !!}
    {!! Form::close() !!}

@endsection