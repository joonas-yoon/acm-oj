@extends('master')

@section('content')
<div class="ui grid stackable relaxed page">
  
  <div class="sixteen wide mobile five wide tablet five wide computer column">
    
    <div class="ui fluid card">
      <div class="content">
        <div class="header">{{ $user->name }}</div>
        <div class="meta">
          <a class="group">{{ $user->email }} 또는 소속</a>
        </div>
        <div class="description">
          이 쯤에 한마디가 들어와주면 아주 적당한 위치가 됩니다. 근데 한마디가 짧으면 좀 없어보이니까 길게 적어야 할거에요.
        </div>
      </div>
      <div class="extra content">
        <a class="right floated" href="/solutions/?user={{ $user->name }}">
          <i class="icon bar chart"></i>&nbsp;{{ number_format($user->getTotalRate(),2) }} %
        </a>
        <a class="solved" href="/solutions/?user={{ $user->name }}&result_id={{ \App\Result::getAcceptCode() }}">
          <i class="icon diamond"></i>{{ $user->total_clear }} Solved
        </a>
      </div>
    </div>
    
    <div class="ui divided selection result list">
      @foreach( \App\Result::getOpenResults()->get() as $result )
        @if( $result->id > 3  && $result->published )
        <a class="item {{ $result->class_name }}" href="/solutions?user={{ '' }}&result_id={{ $result->id }}">
          {{ $result->description }}
          <div class="ui horizontal right floated {{ $result->class_name }} label">{{ \App\Solution::getSolutionsByOption(['username' => '', 'result_id' => $result->id])->count() }}</div>
        </a>
        @endif
      @endforeach
    </div>
  
  </div>
  <div class="sixteen wide mobile eleven wide tablet eleven wide computer column">
    <div class="ui segments">
      <h5 class="ui top attached header">해결한 문제들</h5>
      <div class="ui attached stacked blue segment">
        @foreach( $user->getAcceptProblems() as $problem )
          <span>{{ $problem->id }}</span>
        @endforeach
      </div>
    </div>
    <div class="ui hidden divider"></div>
    <div class="ui segments">
      <h5 class="ui top attached header">도전 중인 문제들</h5>
      <div class="ui attached stacked blue segment">
        @foreach( $user->getTriedProblems() as $problem )
          <span>{{ $problem->id }}</span>
        @endforeach
      </div>
    </div>
  </div>
  
</div>
@stop

@section('script')

@stop