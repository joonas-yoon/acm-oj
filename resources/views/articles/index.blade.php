@extends('master')

@section('content')
    <h1 class="ui header">Articles Page</h1>
    <p>This example shows how to fetch data on database by laravel.</p>

    <div class="ui divider"></div>

    <a class="fluid ui button" href="/articles/create">Write a Article</a>

    @if( count($articles) > 0 )
    <div class="ui divided items">
        @foreach($articles as $article)
        <div class="item">
            <div class="content">
                <a class="header" href="{{ action('ArticlesController@show', [$article->id]) }}">{{ $article->title }}</a>
                <div class="meta">
                    <i class="write icon"></i> Written by {{ $article->user->name }}
                </div>
                <div class="description">
                    <img class="ui wireframe image" src="/images/short-paragraph.png">
                </div>
                <div class="extra">
                    <i class="calendar icon"></i>Posted {{ $article->published_at->diffForHumans() }} <br/>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    @else
    <p>No Items.</p>
    @endif
@stop