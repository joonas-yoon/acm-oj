@extends('master')

@section('content')
<div class="ui grid stackable relaxed page">
  <div class="sixteen wide mobile four wide tablet four wide computer column">
    
    @include('users.menu', compact('user'))
    
  </div>
  <div class="sixteen wide mobile eleven wide tablet eleven wide computer column">
    <div class="ui fluid segment">
      안녕하세요
    </div>
  </div>
</div>
@stop

@section('script')
  <script>
    
  </script>
@stop