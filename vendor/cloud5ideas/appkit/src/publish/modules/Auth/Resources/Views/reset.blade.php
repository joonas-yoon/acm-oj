@extends('auth::layouts.auth')

@section('title')
    @parent
    Reset Your Password
@stop

@section('content')

    {!! Form::open(['url' => '/password/reset'])!!}
        {!! Form::hidden('token', $token) !!}
        <fieldset>
            <div class="form-group">
                {!! Form::email('email', old('email'), ['class' => 'form-control', 'placeholder' => 'E-mail']) !!}
            </div>
            <div class="form-group">
                {!! Form::password('password', ['class' => 'form-control', 'placeholder' => 'Password']) !!}
            </div>
            <div class="form-group">
                {!! Form::password('password_confirmation', ['class' => 'form-control', 'placeholder' => 'Confirm Password']) !!}
            </div>
            {!! Form::submit('Reset Password', ['class' => 'btn btn-primary btn-block']) !!}
        </fieldset>
    {!! Form::close() !!}

@endsection