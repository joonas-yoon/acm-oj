@extends('master')

@section('content')
<h2 class="ui header">Problems</h2>

<table class="ui striped padded table unstackable">
  <thead>
    <tr>
      <th>ID</th>
      <th>Title</th>
      <th>Accepts</th>
      <th>Submits</th>
      <th>Rate</th>
    </tr>
  </thead>
  <tbody>
    @foreach($problems as $problem)
    <tr>
      <td>
        {{ $problem->id }}
      </td>
      <td>
        <a href="{{ url('/problems/'.$problem->id) }}">{{ $problem->title }}</a>&nbsp;&nbsp;

        @if( $problem->is_special )
          <a class="ui teal basic label">스페셜 저지</a>
        @endif

        <? if( ($a=rand(0,10))==2 ){ ?>
          <a class="ui red basic label">도전 중</a>
        <? } else if( rand(0,10) < 1 ){ ?>
          <a class="ui green basic label">해결</a>
        <? } ?>
      </td>
      <td><?=$a?></td>
      <td><?=($b=rand($a,100))?></td>
      <td><? $c=$b>0?$a/$b:0; printf("%.02f", 100*$c); ?>%</td>
    </tr>
    @endforeach
  </tbody>
</table>
@stop