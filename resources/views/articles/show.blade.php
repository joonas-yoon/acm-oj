@extends('master')
 
@section('content')
    <h1 class="ui header">{{ $article->title }}</h1>
    <article class="ui text">
        {{ $article->body }}
    <article>
    <p>{{ $article->published_at }}</p>
@stop