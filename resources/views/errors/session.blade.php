@if( Session::has('success') )
  <div class="ui green message">
    <div class="content">
      <i class="checkmark icon"></i>&nbsp;
      {!! Session::get('success') !!}
    </div>
  </div>
@endif

@if( Session::has('error') )
  <div class="ui red message">
    <div class="content">
      <i class="warning icon"></i>&nbsp;
      {!! Session::get('error') !!}
    </div>
  </div>
@endif