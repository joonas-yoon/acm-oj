@extends('master')

@section('title')
유저 정보 - {{ $user->name }}
@stop

@section('content')
<div class="ui grid stackable relaxed page">
  
  <div class="sixteen wide mobile five wide tablet five wide computer column">
    
    <div class="ui fluid card">
      <div class="content">
        <div class="image rounded rectangle crop right floated">
          <img class="avatar-image rounded rectangle portrait photo" alt="User Profile Photo" src="{{ $user->photo_link }}">
        </div>
        <div class="header">{{ $user->name }}</div>
        <div class="meta">
          <a class="group">
            {{ $user->email_open ? $user->email : '' }} <br/>
            {{ $user->organization }}</a>
        </div>
        <div class="description" style="padding-top:0.5rem;">
          {{ $user->via ? $user->via : '인사말이 없습니다.' }}
        </div>
      </div>
      <div class="extra content">
        <a class="right floated" href="/solutions/?user={{ $user->name }}">
          <i class="icon bar chart"></i>&nbsp;{{ number_format($user->getTotalRate(),2) }} %
        </a>
        <a class="solved" href="/solutions/?user={{ $user->name }}&result_id={{ \App\Models\Result::acceptCode }}">
          <i class="icon diamond"></i>{{ $user->total_clear }} Solved
        </a>
      </div>
    </div>
    
    <div class="ui divided selection result list">
      @foreach( \App\Models\Result::all() as $result )
        @if( $result->id > 3 && $result->published )
        <a class="item {{ $result->class_name }}" href="/solutions?user={{ $user->name }}&result_id={{ $result->id }}">
          {{ $result->description }}
          <div class="ui horizontal right floated {{ $result->class_name }} label">{{ $statisticsService->getResultCountByUser($user->id, $result->id) }}</div>
        </a>
        @endif
      @endforeach
    </div>
  
  </div>
  <div class="sixteen wide mobile eleven wide tablet eleven wide computer column">
    <div class="ui segments">
      <h5 class="ui top attached header">해결한 문제들</h5>
      <div class="ui attached blue segment">
        <div class="ui light grey labels">
        @foreach( $acceptProblem as $stastics )
          <a class="ui label" href="/problems/{{ $stastics->problems->id }}">
            {{ $stastics->problems->id }}
            <span class="detail">{{ $stastics->problems->title }}</span>
          </a>
        @endforeach
        </div>
      </div>
      <div class="ui bottom attached blue progress" data-percent="{{ $user->getTotalRate() }}">
        <div class="bar"></div>
      </div>
    </div>
    <div class="ui hidden divider"></div>
    <div class="ui segments">
      <h5 class="ui top attached header">도전 중인 문제들</h5>
      <div class="ui attached blue segment">
        <div class="ui light grey labels">
        @foreach( $triedProblem as $stastics )
          <a class="ui label" href="/problems/{{ $stastics->problems->id }}">
            {{ $stastics->problems->id }}
            <span class="detail">{{ $stastics->problems->title }}</span>
          </a>
        @endforeach
        </div>
      </div>
      <div class="ui bottom attached progress" data-percent="{{ $userTriedProblemRate }}">
        <div class="bar"></div>
      </div>
    </div>
  </div>
  
  
  <div class="ui basic modal photo">
    <img class="ui centered image" src="{{ $user->photo_link }}">
  </div>
  
</div>
@stop

@section('script')
  <script>
  $('.ui.progress').progress();
  $('.ui.modal.photo')
    .modal('setting', 'transition', 'fade up')
    .modal('attach events', '.ui.card .image .photo', 'show')
  ;
  </script>
@stop