@extends('master')

@section('title')
{{ $problem->id }}번 - {{ $problem->title }}
@stop

@section('content')
  
<div class="ui container">
  
  @include('problems.nav', ['problem_id' => $problem->id])
  
  @if( if_route(['problems.preview']) )
    @if( $problem->status == App\Models\Problem::hiddenCode )
    <div class="ui icon warning message">
      <i class="warning icon"></i>
      <div class="content">
        <div class="header">현재 작성중인 문제입니다.</div>
        <p>이 문제에 대한 행동을 취할 수 없습니다.</p>
      </div>
    </div>
    @else
    <div class="ui icon info message">
      <i class="book icon"></i>
      <div class="content">
        <div class="header">
          {{ $problem->id }}번 미리보기
        </div>
        <p>이 문제에 대한 행동을 취할 수 있습니다.</p>
        @if( is_admin() )
          @if( $problem->status == App\Models\Problem::readyCode )
          <a class="ui labeled icon positive button" href="/problems/{{ $problem->id }}/publish">
            <i class="plus icon"></i> 공개하기
          </a>
          @elseif( $problem->status == App\Models\Problem::openCode )
          <a class="ui labeled icon negative button" href="/problems/{{ $problem->id }}/publish/cancel">
            <i class="minus icon"></i> 보류하기
          </a>
          @endif
        @endif
        <a class="ui labeled icon basic teal button" href="/problems/create/data?problem={{ $problem->id }}">
          <i class="inbox icon"></i> 데이터 추가
        </a>
        <a class="ui labeled icon vk button" href="/problems/{{ $problem->id }}/edit">
          <i class="pencil icon"></i> 수정하기
        </a>
        <a class="ui labeled icon negative button">
          <i class="trash icon"></i> 삭제하기
        </a>
      </div>
    </div>
    @endif
  @endif
  
  @if( $problem->is_special )
  <a class="ui red ribbon label">스페셜 저지</a>
  @endif

  <h2 class="ui header">
    {{ $problem->title }}
    @if( Sentinel::check() )
      @if( $problem->userAccept > 0 )
        <a class="ui green basic label">해결</a>
      @elseif( $problem->userAccept == 0 )
        <a class="ui red basic label">도전 중</a>
      @endif
    @endif
    @if( is_admin() && ! if_route(['problems.preview']) )
      <a href="/problems/preview/{{ $problem->id }}"><i class="setting icon"></i></a>
    @endif
  </h2>

  <table class="ui celled padded single line table segment unstackable">
  <thead><tr>
    <th>시간 제한</th>
    <th>메모리 제한</th>
    <th>정답 수</th>
    <th>제출 수</th>
    <th>정답률</th>
    <th>난이도</th>
    <th>태그 보기</th>
  </tr></thead>
  <tbody><tr>
    <td>{{ $problem->time_limit }} 초</td>
    <td>{{ $problem->memory_limit }} MB</td>
    <td>{{ $ac = ($problem->problemStatisticses->first()? $problem->problemStatisticses->first()->count : 0) }}</td>
    <td>{{ $sc = $problem->total_submit }}</td>
    <td>{{ number_format(StatisticsService::getRate($ac, $sc), 2) }} %</td>
    <td>
      <div class="ui star rating" data-rating="5"></div>
    </td>
    <td>
      <div class="ui toggle checkbox vhint">
        <label><i class="eye icon"></i></label>
        <input type="checkbox" name="vhint">
      </div>
      @if( $problem->userAccept > 0 )
      <button class="ui icon tiny compact positive add tag button">
        <i class="plus icon"></i>
      </button>
      @endif
    </td>
  </tr></tbody>
  </table>

  <div id="problem">

    <div class="ui horizontal divider"><i class="pencil icon"></i>&nbsp;&nbsp;문제 설명</div>
    <div class="context">{!! $problem->description !!}</div>

    <div class="ui horizontal divider">입력 형식</div>
    <div class="context">{!! $problem->input !!}</div>

    <div class="ui horizontal divider">출력 형식</div>
    <div class="context">{!! $problem->output !!}</div>

    <div class="ui horizontal divider">예제</div>

    <div class="ui stackable grid">
      <div class="eight wide column">
        <div class="ui segment code">
          <div class="ui top attached label">입력</div>
          <pre>{{ $problem->sample_input }}</pre>
        </div>
      </div>
      <div class="eight wide column">
        <div class="ui segment code">
          <div class="ui top attached label">출력</div>
          <pre>{{ $problem->sample_output }}</pre>
        </div>
      </div>
    </div>

    <div class="ui horizontal divider">Hint</div>
    <div class="context">
      {!!  $problem->hint !!}
      <div class="vhint tags">
        <h2 class="ui sub header">이 문제의 인기 태그 TOP3 </h2>
        @if( count($tags) > 0 )
          @foreach( $tags as $tag )
            <a class="ui tag label" href="/tags/{{ $tag->id }}">{{ $tag->name }}</a>
          @endforeach
        @endif
      </div>
      
      @if( isset($myTags) && $problem->userAccept > 0 )
        <h2 class="ui sub header">내가 추가한 태그: </h2>
        @foreach( $myTags as $tag )
          @if( $tag->status != \App\Models\Tag::openCode )
          <a class="ui tag label disabled"><i class="spinner loading icon"></i> {{ $tag->name }} (검토중)</a>
          @else
          <a class="ui tag label" href="/tags/{{ $tag->id }}">{{ $tag->name }}</a>
          @endif
        @endforeach
      @endif
    </div>

    <div class="ui horizontal divider"><i class="heart icon"></i>&nbsp;Thanks to</div>
    <div class="context">
      <div class="ui label">
        번역
        <a class="detail">@author1 @author2</a>
      </div>
      <div class="ui label">
        오타
        <a class="detail">@author3</a>
      </div>
    </div>

  </div>
  
  @if( $problem->userAccept > 0 )
  <div class="ui add tag small modal">
    <div class="header">어떤 알고리즘을 사용하셨나요?</div>
    <div class="content">
      <p>문제 해결에 사용하신 알고리즘을 선택하여, 문제에 태그를 추가해주세요!</p>
      <p>
        <i class="help circle icon"></i> 태그에 대해 자세히 알고싶다면,&nbsp;
        <a href="/tags/">태그 목록</a>을 참고하세요.
      </p>
      <div class="ui info message">
        <p>새로운 태그를 추가하시면, 관리자 승인 후 추가됩니다.</p>
      </div>
      <form method="post" action="{{ action('ProblemsController@insertTags', $problem->id) }}" class="ui tags form">
        {!! csrf_field() !!}
        <input type="hidden" name="problem_id" value="{{ $problem->id }}"/>
        <select name="tags[]" multiple="" class="ui search multiple tags dropdown">
          <option value="">선택하세요.</option>
          @foreach( App\Models\Tag::getOpenTags()->get() as $tag )
          <option value="{{ $tag->name }}">{{ $tag->name }}</option>
          @endforeach
        </select>
      </form>
    </div>
    <div class="actions">
      <div class="ui approve positive button">다 골랐어요!</div>
      <div class="ui cancel button">나중에 할게요</div>
    </div>
  </div>
  <div class="ui result tag small modal">
    <h2 class="ui icon header" style="padding-top:3em; padding-bottom:3em;">
      <i class="gift icon"></i>
      <div class="content">
        <div class="sub header">소중한 의견을 작성해주셔서 감사합니다!</div>
      </div>
    </h2>
  </div>
  <script>
  $('.add.tag.modal')
    .modal('attach events', '.add.tag.button')
    .modal({
      onApprove: function(){
        $('.result.tag.modal')
          .modal({
            blurring: true,
            onVisible: function(){
              $('form.tags').submit();
            }
          })
          .modal('show');
      }
    })
  ;
  
  $('.ui.tags.dropdown')
    .dropdown({
      allowAdditions: true,
      maxSelections: 3,
      message: {
        addResult     : '새로운 태그: <b>{term}</b>',
        count         : '선택한 항목 {count} 개',
        maxSelections : '최대 {maxCount}개 까지 등록할 수 있습니다.',
        noResults     : '일치하는 결과가 없습니다.'
      }
    })
    .dropdown('set selected',[
      @foreach( (isset($myTags) ? $myTags : []) as $tag )
        '{{ $tag->name }}',
      @endforeach
    ])
  ;
  </script>
  @endif
  
  <div class="ui horizontal divider">Comments</div>

  <div class="ui threaded comments" id="comments">
  <div class="comment">
    <a class="avatar">
      <img src="/images/no-image.png">
    </a>
    <div class="content">
      <a class="author">Matt</a>
      <div class="metadata">
        <span class="date">Today at 5:42PM</span>
      </div>
      <div class="text">
        How artistic!
      </div>
      <div class="actions">
        <a class="reply">Reply</a>
      </div>
    </div>
  </div>
  <div class="comment">
    <a class="avatar">
      <img src="/images/no-image.png">
    </a>
    <div class="content">
      <a class="author">Elliot Fu</a>
      <div class="metadata">
        <span class="date">Yesterday at 12:30AM</span>
      </div>
      <div class="text">
        <p>This has been very useful for my research. Thanks as well!</p>
      </div>
      <div class="actions">
        <a class="reply">Reply</a>
      </div>
    </div>
    <div class="comments">
      <div class="comment">
        <a class="avatar">
          <img src="/images/no-image.png">
        </a>
        <div class="content">
          <a class="author">Jenny Hess</a>
          <div class="metadata">
            <span class="date">Just now</span>
          </div>
          <div class="text">
            Elliot you are always so right :)
          </div>
          <div class="actions">
            <a class="reply">Reply</a>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="comment">
    <a class="avatar">
      <img src="/images/no-image.png">
    </a>
    <div class="content">
      <a class="author">Joe Henderson</a>
      <div class="metadata">
        <span class="date">5 days ago</span>
      </div>
      <div class="text">
        Dude, this is awesome. Thanks so much
      </div>
      <div class="actions">
        <a class="reply">Reply</a>
      </div>
    </div>
  </div>
  <form class="ui reply form">
    <div class="field">
      <textarea></textarea>
    </div>
    <div class="ui blue labeled submit icon button">
      <i class="icon edit"></i> 작성하기
    </div>
  </form>
  </div>
</div>
@stop

@section('script')
  <script>
  $('.ui.sticky')
    .sticky({
      context: '#problem',
      offset: 10
    })
  ;
  $('.ui.search')
    .search({
      apiSettings: {
        url: '/search-fast/?q={query}'
      },
      type: 'category'
    })
  ;
  $('.ui.rating')
    .rating({
      initialRating: 2,
      maxRating: 5
    })
  ;

  $('.vhint.checkbox')
    .checkbox({
      onChange: function() {
        $('.vhint.tags').fadeToggle(500);
      }
    })
  ;
  </script>
@stop