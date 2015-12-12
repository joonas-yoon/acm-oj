@extends('master')

@section('title')
404 Not Found
@stop

@section('content')
<link href="https://fonts.googleapis.com/css?family=Lato:100" rel="stylesheet" type="text/css">
<style>   
.error-page {
    text-align: center;
    display: block;
    vertical-align: middle;
    padding: 5em 0;
}

.error-page .content {
    display: inline-block;
}

.error-page .title {
    color: #333;
    font-size: 11.4rem;
    font-weight: 400;
    margin: 5px auto;
}
</style>
        
<div class="error-page text-center">
    <h2 class="ui header">
      <p class="title">404</p>
      <div class="content">
          <div class="sub header">페이지를 찾을 수 없습니다.</div>
      </div>
    </h2>
</div>
@stop

@section('script')

@stop