@extends('master')

@section('title'){{ isset($title) ? $title : '' }}@stop
@section('content')
<div class="ui container">

  @include('problems.nav')

  @include('errors.list')
  
  <div class="ui icon message">
    <i class="inbox icon"></i>
    <div class="content">
      <div class="header">
        문제 만들기
      </div>
      <p>온라인 저지에 추가되었으면 하는 문제를 작성해주세요.</p>
      <a href="{{ action('ProblemsController@create') }}" class="ui right labeled icon button">
        <i class="right pencil icon"></i>
        작성하기
      </a>
    </div>
  </div>

  <table class="ui striped text-center table unstackable">
    <thead>
      <tr>
        <th class="one wide">번호</th>
        <th>문제 제목</th>
        <th>상태</th>
      </tr>
    </thead>
    <tbody>
      @foreach($problems as $problem)
      <tr>
        <td>
          {{ $problem->id }}
        </td>
        <td class="text-left">
          <a href="{{ action('ProblemsController@preview', $problem->id) }}">{{ $problem->title }}</a>&nbsp;&nbsp;

          @if( $problem->is_special )
            <a class="ui teal basic label">스페셜 저지</a>
          @endif
        </td>
        <td>
          @if( $problem->status == App\Models\Problem::hiddenCode )
          <a href="{{ action('ProblemsController@edit', $problem->id) }}" class="ui green tiny button">문제 수정</a>
            @if( $problem->datafiles )
            <a href="{{ url('/problems/create/data?problem='.$problem->id) }}" class="ui teal tiny button">데이터 변경</a>
            @else
            <a href="{{ url('/problems/create/data?problem='.$problem->id) }}" class="ui green tiny button">데이터 추가</a>
            @endif
          <a href="#" class="ui blue tiny button problem-confirm" data-problem-title="{{ $problem->title }}" data-problem-id="{{ $problem->id }}">작성 완료</a>
          @else
          <a class="ui tiny button disabled"><i class="spinner loading icon"></i> 검토중..</a>
            @if( $problem->datafiles )
            <a class="ui tiny button disabled"><i class="check icon"></i> 데이터 추가됨</a>
            @endif
          @endif
        </td>
      </tr>
      @endforeach
    </tbody>
  </table>

  <div class="ui basic modal" id="confirmProblem">
    <i class="close icon"></i>
    <div class="header">
      등록 요청하기
    </div>
    <div class="image content">
      <div class="image">
        <i class="archive icon"></i>
      </div>
      <div class="description">
        <p>&quot;확인&quot;을 누르시면, 더 이상 문제를 수정하실 수 없습니다.</p>
        <p>계속 하시겠습니까?</p>
      </div>
    </div>
    <div class="actions">
      <div class="two fluid ui inverted buttons">
        <div class="ui red basic inverted deny button">
          <i class="remove icon"></i>
          취소
        </div>
        <div class="ui green basic inverted approve button">
          <i class="checkmark icon"></i>
          확인
        </div>
      </div>
    </div>
    <form method="post">
      <input type="hidden" name="problem_id" value=""/>
      <input type="hidden" name="from" value="confirm"/>
      {!! csrf_field() !!}
    </form>
  </div>

  @include('pagination.default', ['paginator' => $problems])

</div>
@stop

@section('script')
  <script>
  $('.ui.progress').progress();
  $('.problem-confirm').on('click', function(e){
    var pageId = '#confirmProblem'
    var page = $(pageId);
    var id = $(this).attr('data-problem-id');
    var title = $(this).attr('data-problem-title');
    $(pageId + " .header").html( id + "번 문제 작성 완료");
    page.modal({
      selector  : {
        close   : '.close, .actions .deny',
        approve : '.actions .approve',
        deny    : '.actions .negative, .actions .deny, .actions .cancel'
      },
      onDeny    : function(){ return false; },
      onApprove : function() {
        if( id ){
          var form = $(this).find('form');
          form.attr('action', '/problems/'+id+'/status');
          form.find('input[name=problem_id]').val(id);
          form.submit();
          return true;
        }
        return false;
      }
    })
    .modal('show');
  });
  </script>
@stop