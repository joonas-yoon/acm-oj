@extends('master')

@section('content')

  <div class="ui breadcrumb" style="padding:1em 0;">
    <a class="section">Home</a>
    <i class="right chevron icon divider"></i>
    <a class="section">Problems</a>
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
    <a class="item" href="#">
      제출하기
    </a>
    <a class="item" href="#">
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

  <table class="ui celled padded single line table segment">
  <thead><tr>
    <th>시간 제한</th>
    <th>메모리 제한</th>
    <th>제출 수</th>
    <th>정답 수</th>
    <th>정답률</th>
    <th>평점</th>
    <th>분류/태그</th>
  </tr></thead>
  <tbody><tr>
    <td>{{ $problem->time_limit }} MS</td>
    <td>{{ $problem->memory_limit }} MB</td>
    <td>0</td>
    <td>0</td>
    <td>0 %</td>
    <td>
      <div class="ui star rating" data-rating="5"></div>
    </td>
    <td>
      <a href="#"><i class="lock icon"></i></a>
    </td>
  </tr></tbody>
  </table>

  <div id="problem">

    @if ($problem->is_special)
    <a class="ui red ribbon label">Special Judge</a>
    @endif

    <h2 class="ui dividing header">Description</h2>
    <div class="context">{{{ $problem->description."<hr/>" }}}</div>

    <h2 class="ui dividing header">입력 형식</h2>
    <div class="context">{{{ $problem->input }}}</div>

    <h2 class="ui dividing header">출력 형식</h2>
    <div class="context">{{{ $problem->output }}}</div>

    <h2 class="ui dividing header">예제</h2>
    <div class="ui grid">
      <div class="eight wide column">
        <div class="ui segment inverted">
          <div class="ui top attached label">입력</div>
          <pre>{{ $problem->sample_input }}</pre>
        </div>
      </div>
      <div class="eight wide column">
        <div class="ui segment inverted">
          <div class="ui top attached label">출력</div>
          <pre>{{ $problem->sample_output }}</pre>
        </div>
      </div>
    </div>

    <h2 class="ui dividing header">Hint</h2>
    <div class="context">{{{ $problem->hint }}}</div>
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
  </script>
@stop