@extends('master')
 
@section('content')

    <div class="ui piled segment">
        <h1 class="ui header">
            <a class="ui right pointing red basic label">Edit</a>
            {!! $article->title !!}
        </h1>
        
        <div class="ui divider"></div>
        
        @include('errors.list')

        {!! Form::model($article, ['method' => 'PATCH', 'url' => action('ArticlesController@index') .'/'. $article->id, 'class' => 'ui form']) !!}
            @include('articles.form', ['submitButtonText' => 'Update Article'])
        {!! Form::close() !!}
    </div>
 
@stop