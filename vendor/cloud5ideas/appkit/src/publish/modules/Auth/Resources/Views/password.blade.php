@extends('auth::layouts.auth')

@section('title')
    @parent
    Reset Password
@stop

@section('content')

    {!! Form::open(['url' => '/password/email'])!!}
        <fieldset>
            <div class="form-group">
                {!! Form::email('email', old('email'), ['class' => 'form-control', 'placeholder' => 'E-mail']) !!}
            </div>
            {!! Form::submit('Request Password Reset', ['class' => 'btn btn-primary btn-block']) !!}
        </fieldset>
    {!! Form::close() !!}

@endsection