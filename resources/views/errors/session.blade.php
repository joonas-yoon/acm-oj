@if( Session::has('success') )
  <div class="ui success message">
    <div class="content">
        {!! Session::get('success') !!}
    </div>
  </div>
@endif

@if( Session::has('error') )
  <div class="ui negative message">
    <div class="content">
        {!! Session::get('error') !!}
    </div>
  </div>
@endif