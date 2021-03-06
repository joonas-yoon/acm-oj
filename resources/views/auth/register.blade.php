@extends('master')

@section('title')
회원가입
@stop

@section('content')

<div class="ui middle aligned center aligned grid page">
  <div class="column" style="max-width:450px;">
      
        {!! Form::open(['url' => url('/register'), 'class' => 'ui form stacked segment']) !!}
            {!! csrf_field() !!}

            <h2 class="ui icon header">
                <i class="lock icon"></i><div class="clear"></div>
                <div class="content">Sign up</div>
            </h2>
            <div class="ui divider"></div>

            <div class="ui field">
                <div class="ui left icon input">
                {!! Form::text('name', Input::old('name'), ['placeholder' => '아이디']) !!}
                <i class="user icon"></i></div>
            </div>

            <div class="ui field">
                <div class="ui left icon input">
                {!! Form::text('email', Input::old('email'), ['placeholder' => '이메일 주소']) !!}
                <i class="mail outline icon"></i></div>
            </div>

            <div class="ui field">
                <div class="ui left icon input">
                {!! Form::password('password', ['placeholder' => '비밀번호']) !!}
                <i class="unlock alternate icon"></i></div>
            </div>

            <div class="ui field">
                <div class="ui left icon input">
                {!! Form::password('password_confirmation', ['placeholder' => '비밀번호 확인']) !!}
                <i class="lock icon"></i></div>
            </div>

            @if (count($errors) > 0)
                <div class="ui red message">
                    <ul class="list">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            {!! Form::submit('등록하기', ['class' => 'ui submit button']) !!}
            <div class="ui horizontal divider">Or</div>
            <p>이미 가입하셨다면, <a href="{{ url('/login') }}">로그인</a>을 해주세요.</p>
        {!! Form::close() !!}
    </div>
    </div>
@endsection
