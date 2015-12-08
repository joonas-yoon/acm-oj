@extends('master')

@section('content')
<div class="ui container">
    <div class="ui dividing header">디버그 코드</div>
    {{ var_dump($code) }}

    <br/><br/>

    <div class="ui dividing header">제출된 코드</div>
    <pre style="background-color:#ddd;padding:1em;">{{ $code->code }}</pre>
</div>
@stop

@section('script')

@stop