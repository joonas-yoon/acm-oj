@extends('master')

@section('title')
문제 제작 - {{ $problem_id }}번 데이터 추가하기
@stop

@section('content')
<div class="ui container">

  @include('problems.maker.step',
  ['step1' => 'completed', 'step2' => 'active', 'step3' => 'disabled' ])

  @include('errors.list')

  {!! Form::open(array('url'=>'/problems/create/data', 'method'=>'POST', 'files'=>true, 'class'=>'ui form')) !!}
  {!! Form::hidden('problem', $problem_id) !!}

  <div class="segment">
    <div class="ui red message">
      <p><i class="icon warning"></i> &nbsp; <strong>조심하세요!</strong> 기존에 있던 데이터는 <strong>전부 삭제</strong>됩니다.</p>
      
      <div class="text-center">
        <label for="file" class="ui icon big fluid file basic red button" style="margin:2rem auto; padding: 3em 1.5em;">
          <i class="upload icon"></i>&nbsp;
          <span class="content">파일 열기</span>
        </label>
        {!! Form::file('dataFiles[]', ['multiple', 'class'=>'file-input', 'accept'=>'.in,.out', 'style'=>'display:none;'] ) !!}
      </div>
    </div>
  </div>
  <div class="text-center">
    @if( $hasData )
    <div class="ui horizontal divider">Or </div>
    <a class="ui teal labeled icon button" href="/problems/{{ $problem_id }}/download/data">
      기존 데이터 다운로드
      <i class="download icon"></i>
    </a>
    @endif
  
    <div class="ui divider"></div>
    <a href="/problems/preview/{{ $problem_id }}" class="ui button">문제 보러가기</a>
    <a href="/problems/create/list" class="ui green button">나중에 하기</a>
    {!! Form::submit('데이터 추가하기', ['class' => 'ui blue button']) !!}
  </div>

  {!! Form::close() !!}

</div>
@stop

@section('script')
  <script>
  $('label[for=file]').on('click', function(){
    $('input[type=file]').click();
  });
  $('input[type=file]').on('change', function(){
    var input = $(this)[0];
    var files = input.files;
    var size = files.length;
    var message = $('label[for=file] .content');
    if( size > 1 ) {
      message.html( files[0].name + ' 등 파일 ' + size +' 개' );
    } else if( size == 1 ){
      message.html( files[0].name );
    } else {
      message.html("파일 없음");
    }
    console.log( files );
  });
  </script>
@stop