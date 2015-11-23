@extends('master')

@section('content')

  <div class="ui breadcrumb" style="padding-bottom:1em;">
    <a class="section" href="/problems">Problems</a>
    <i class="right chevron icon divider"></i>
    <div class="active section">{{ $problem->id }}. {{ $problem->title }}</div>
  </div>

  <div class="ui pointing sticky menu" id="problemnav">
    <a class="item {{ App\Helpers::setActive('problems.show', Route::current()) }}" href="#">
      {{ $problem->id }}번: {{ $problem->title }}
    </a>
    <a class="item" href="#">
      (출처)
    </a>
    <a class="item" href="/submit/{{ $problem->id }}">
      제출하기
    </a>
    <a class="item" href="/solutions?from=problem&problem_id={{ $problem->id }}">
      채점 현황
    </a>
    <div class="right menu">
      <div class="ui category search item">
        <div class="ui transparent icon input">
          <input class="prompt" type="text" placeholder="Search problem...">
          <i class="search link icon"></i>
        </div>
        <div class="results"></div>
      </div>
    </div>
  </div>

  <table class="ui celled padded single line table segment unstackable">
  <thead><tr>
    <th>시간 제한</th>
    <th>메모리 제한</th>
    <th>제출 수</th>
    <th>정답 수</th>
    <th>정답률</th>
    <th>평점</th>
    <th>태그 보기</th>
  </tr></thead>
  <tbody><tr>
    <td>{{ $problem->time_limit }} 초</td>
    <td>{{ $problem->memory_limit }} MB</td>
    <td>{{ $problem->getSubmitCount() }}</td>
    <td>{{ $problem->solutions_accept()->count() }}</td>
    <td>{{ $problem->getRate() }} %</td>
    <td>
      <div class="ui star rating" data-rating="5"></div>
    </td>
    <td>
      <div class="ui toggle checkbox vhint">
        <input type="checkbox" name="vhint">
        <label><i class="eye icon"></i></label>
      </div>
    </td>
  </tr></tbody>
  </table>

  <div id="problem">

    @if ($problem->is_special)
    <a class="ui red ribbon label">스페셜 저지</a>
    @endif
    <a class="ui red basic label">도전 중</a>
    <a class="ui green basic label">해결</a>

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
        <a class="ui tag label">Brute Force</a>
        <a class="ui tag label">Greed</a>
      </div>
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
        url: 'custom-search/?q={query}'
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