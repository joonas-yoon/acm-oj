@extends('master')

@section('title')
채점 현황 - {{ $solutions->currentPage() }} 페이지
@stop

@section('content')
<div class="ui container">

  @if( if_query('from', 'problem') && if_query('problem_id', true) )
  
    @include('problems.nav')
    
  @elseif( $fromWhere == 'contest' )
  
    대회로부터 넘어옴<br/><br/>
  
  @endif
  
  <!-- search form -->
  <form method="GET" class="ui form">
    <div class="five fields">
      <div class="field">
        <label for="problem_id">문제 번호</label>
        <input type="text" name="problem_id" placeholder="문제 번호" value="{{ $problem_id }}" />
      </div>
      <div class="field">
        <label for="user">아이디</label>
        <input type="text" name="user" placeholder="아이디" value="{{ $username }}" />
      </div>
      <div class="field">
        <label for="lang_id">언어</label>
        <select class="ui fluid search selection dropdown" name="lang_id" value="{{ $lang_id }}">
          <option value="0">모든 언어</option>
          @foreach($langRefs as $option)
          <option value="{{ $option->id }}" {{ $option->id == $lang_id ? 'selected':'' }}>{{ $option->name }}</option>
          @endforeach
        </select>
      </div>
      <div class="field">
        <label for="result_id">결과</label>
        <select class="ui fluid search selection dropdown" name="result_id" value="{{ $result_id }}">
          <option value="0">모든 결과</option>
          @foreach($resultRefs as $option)
          <option value="{{ $option->id }}" {{ $option->id == $result_id ? 'selected':'' }}>{{ $option->description }}</option>
          @endforeach
        </select>
      </div>
      <div class="field">
        <label>&nbsp;</label>
        <button type="submit" class="ui fluid blue button"><i class="search icon"></i>&nbsp;검색</button>
      </div>
    </div>
  </form>

  <table class="ui striped blue table compact single line unstackable">
    <thead>
      <tr>
        <th style="width:7%;">채점 번호</th>
        <th style="width:12%;">제출자</th>
        <th style="width:10%;">문제 번호</th>
        <th>결과</th>
        <th style="width:10%;">시간</th>
        <th style="width:10%;">메모리</th>
        <th style="width:10%;">언어</th>
        <th style="width:10%;">코드 길이</th>
        <th style="width:10%;">제출한 시간</th>
      </tr>
    </thead>
    <tbody>
    @foreach($solutions as $solution)
      <tr>
        <td>{{ $solution->id }}</td>
        <td>
          <a href="/user/{{ $solution->user->name }}">{{ $solution->user->name }}</a>
        </td>
        <td>
          <a class="popup title" href="/problems/{{ $solution->problem->id }}" data-content="{{ $solution->problem->title }}" data-variation="inverted">{{ $solution->problem->id }}</a>
        </td>
        <td>{!! $solution->result->Html !!}</td>
        @if( $solution->result_id == $acceptCode )
        <td>{{ $solution->time }} <span class="solution unit"> MS</span></td>
        <td>{{ $solution->memory }} <span class="solution unit"> KB</span></td>
        @else
        <td></td><td></td>
        @endif
        <td>
          @if( ! Sentinel::check() )
            {{ $solution->language->name }}
          @elseif( $solution->user_id == $getUser_id )
            <a href="/solutions/{{ $solution->id }}">{{ $solution->language->name }}</a>
          @elseif( $solution->is_published
                && $solution->statisticses->first() )
            <a href="/solutions/{{ $solution->id }}">{{ $solution->language->name }}</a>
          @else
            {{ $solution->language->name }}
          @endif
        </td>
        <td>{{ $solution->size }} <span class="solution unit"> B</span></td>
        <td>
          <a class="popup date" data-content="{{ $solution->created_at }}" data-variation="inverted">{{ $solution->created_at->diffForHumans() }}</a>
        </td>
      </tr>
    @endforeach
    </tbody>
  </table>

  @include('pagination.simple', ['paginator' => $solutions])

</div>
@stop

@section('script')
  <script>
  $('a.popup.title').popup({ position : 'left center', transition: 'vertical flip' });
  $('a.popup.date').popup({ position : 'top center', transition: 'vertical flip' });
  $('select.dropdown').dropdown();
  </script>
@stop