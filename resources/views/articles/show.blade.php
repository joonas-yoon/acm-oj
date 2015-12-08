@extends('master')
 
@section('content')
<div class="ui container">
    <h1 class="ui header">{{ $article->title }}</h1>
    <article class="ui text">
        {{ $article->body }}
    <article>
    <p>{{ $article->published_at }}</p>
</div>
@stop