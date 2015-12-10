@extends('master')

@section('title')
{{ $title }}
@stop

@section('content')
<div class="ui grid stackable relaxed page">
  <div class="sixteen wide mobile four wide tablet four wide computer column">
    
    @include('users.menu', compact('user'))
    
  </div>
  <div class="sixteen wide mobile twelve wide tablet twelve wide computer column">
    
    @include($viewContext, compact('user'))
    
  </div>
</div>
@stop

@section('script')
  <script>
    
  </script>
@stop