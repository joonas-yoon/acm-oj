@extends('master')

@section('content')

    <div class="ui one column stackable center aligned page grid">
    <div class="column twelve wide">

        {!! Form::open(['url' => action('Auth\AuthController@postLogin'), 'class' => 'ui form segment raised', 'style' => 'padding: 2rem 4rem;']) !!}
            {!! csrf_field() !!}

            <h2 class="ui icon header">
                <i class="lock icon"></i><div class="clear"></div>
                <div class="content">Sign in</div>
            </h2>
            <div class="ui divider"></div>

            <div class="field">
                <div class="ui left icon input">
                    {!! Form::text('username', Input::old('username'), ['placeholder' => '아이디 또는 이메일']) !!}
                    <i class="user icon"></i>
                </div>
            </div>
            <div class="field">
                <div class="ui left icon input">
                    {!! Form::password('password', ['placeholder' => '비밀번호']) !!}
                    <i class="lock icon"></i>
                </div>
            </div>

            <div class="inline field">
                <div class="ui checkbox">
                    {!! Form::checkbox('remember', 0, null) !!}
                    {!! Form::label('remember', '자동 로그인') !!}
                </div>
            </div>
            
            @if (Session::has('success') )
            <div class="ui green message">
                <i class="checkmark icon"></i>&nbsp;{!! session('success') !!}
            </div>
            @endif
                            
            @if (count($errors) > 0)
            <div class="ui red message">
                <ul class="list">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif
            {!! Form::submit('로그인', ['class' => 'ui blue submit button']) !!}
            <div class="ui horizontal divider">Or</div>
            <p>비밀번호를 잊어버리신 경우, <a href="{{ url('/password/email') }}">여기</a>를 눌러주세요.</p>
        {!! Form::close() !!}
    </div>
    </div>

@endsection
