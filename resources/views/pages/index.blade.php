<!DOCTYPE html>
<html lang="ko">
<head>
  @include('includes.head', ['site_title' => 'Orion Online Judge'])
</head>
<body class="hello">

  @include('includes.navigator', ['isIndex' => true])

  <!-- Start Intro -->
  <div class="ui introhead" id="context">
    <div class="ui container">
      <div class="introduction">
        <h1 class="ui inverted header">
          <img class="logo" src="/images/logo-index.png"/>
          <div class="title">Orion Judge</div>
        </h1>

        <div class="ui hidden divider"></div>
        <p class="subtitle">
          An algorithm refers to a number of steps required for solving a problem.<br/>
          It makes you to become a better, smarter, productive being!<br/>
          Proof it now!
        </p>

        <div class="ui hidden divider"></div>
        <a href="/problems" class="ui inverted download button">문제 목록</a>
        @if( ! Sentinel::check() )
          <a href="/login" class="ui inverted basic button">시작하기</a>
        @endif
      </div>
    </div>
  </div>
  <div class="ui stripe segment">
    <div class="ui four column center aligned divided relaxed stackable grid container">
      <div class="row">
        <div class="column">
          <div class="ui green segment">이 문제는 어때요?</div>
          <?php
          $randProblem = ProblemService::getOpenProblems()->random();
          $ac = 0, $sc = 0;
          if( $randProblem ) {
            $ac = ($randProblem->problemStatisticses->first()? $randProblem->problemStatisticses->first()->count : 0);
            $sc = $randProblem->total_submit;
          }
          $rate = number_format(StatisticsService::getRate($ac, $sc), 2);
          ?>
          @if( $randProblem )
          <div class="ui card">
            @if( Sentinel::check() )
              {{-- 맞은 문제가 안나오고 전체 문제가 카운팅 되고 있음 --}}
              @if( ($uac = $randProblem->statisticses->first()? $randProblem->statisticses->first()->count: -1) > 0 )
              <div class="extra content">
                <i class="check icon"></i>
                해결한 문제입니다!
              </div>
              @elseif( $uac == 0 )
              <div class="extra content">
                <i class="notched circle loading icon"></i>
                도전 중인 문제입니다!
              </div>
              @endif
            @endif
            <div class="content">
              <h2 class="header">{{ $randProblem->title }}</h2>
              <div class="description">
                <p>{{ str_limit(strip_tags(ProblemService::getProblem($randProblem->id)->description), 50, '...') }}</p>
              </div>
            </div>
            <div class="content"><i class="bar chart icon"></i>{{ $ac }} Solved, {{ $rate }}% </div>
            <div class="ui two bottom attached buttons">
              <a class="ui button" href="/solutions/?problem_id={{ $randProblem->id }}">제출 현황</a>
              <a class="ui positive button" href="/problems/{{ $randProblem->id }}">풀러가기</a>
            </div>
          </div>
          @else
          <div class="ui card">
            <div class="content">등록된 문제가 없습니다.</div>
          </div>
          @endif
        </div>
        <div class="column">
          <div class="ui blue segment">새로 추가된 문제</div>
          <div class="ui stacked segments">
            @forelse(ProblemService::getNewestProblems(5) as $problem)
            <div class="ui segment">
              <a href="/problems/{{ $problem->id }}" style="color:#333;">{{ $problem->title }}</a>
            </div>
            @empty
            <div class="ui bottom attached message">
              <i class="notched circle loading icon"></i> 준비중입니다!
            </div>
            @endforelse
          </div>
        </div>
        <div class="column">
          <div class="ui orange segment">빈도가 높은 태그</div>
          <div class="ui stacked segments">
            @forelse(TagService::getOpenTagsWithProblem()->take(5) as $tag)
            <div class="ui segment">
              <a href="/tags/{{ $tag->id }}" style="color:#333;">{{ $tag->name }}</a>
            </div>
            @empty
            <div class="ui bottom attached message">
              <i class="notched circle loading icon"></i> 준비중입니다!
            </div>
            @endforelse
          </div>
        </div>
        <div class="column">
          <div class="ui teal segment">번역을 기다리는 문제</div>
          <div class="ui stacked segments">
            <div class="ui bottom attached message">
              <i class="notched circle loading icon"></i> 준비중입니다!
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="ui stripe alternative segment">
    <div class="ui four statistics">
      <div class="statistic">
        <div class="value">220</div>
        <div class="label">개의 문제</div>
      </div>
      <div class="statistic">
        <div class="text value">
          139<br/>
          <div class="ui star rating" data-rating="2"></div>
        </div>
        <div class="label">개의 평가</div>
      </div>
      <div class="statistic">
        <div class="value">332</div>
        <div class="label">번의 제출</div>
      </div>
      <div class="statistic">
        <div class="value"><i class="child icon"></i>42</div>
        <div class="label">명의 회원</div>
      </div>
    </div>
  </div>

  @include('includes.footer')

  <script>
    $('.ui.rating')
      .rating({
        initialRating: 2,
        maxRating: 5
      })
    ;
  </script>
</body>
</html>