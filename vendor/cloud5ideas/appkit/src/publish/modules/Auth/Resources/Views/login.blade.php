@extends('auth::layouts.auth')

@section('title')
    @parent
    Sign In
@stop

@section('content')

    {!! Form::open(['url' => '/auth/login'])!!}
        <fieldset>
            <div class="form-group">
                {!! Form::email('email', old('email'), ['class' => 'form-control', 'placeholder' => 'E-mail']) !!}
            </div>
            <div class="form-group">
                {!! Form::password('password', ['class' => 'form-control', 'placeholder' => 'Password']) !!}
            </div>
            <div class="checkbox">
                <label>
                    {!! Form::checkbox('remember') !!}
                    Remember Me
                </label>
            </div>
            {!! Form::submit('Login', ['class' => 'btn btn-success btn-block']) !!}
            {!! Html::link(url('/password/email'), 'Forgot Password') !!}
        </fieldset>
    {!! Form::close() !!}

@endsection