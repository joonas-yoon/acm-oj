@extends('master')
 
@section('content')

    <div class="ui piled segment">
        <h1 class="ui header">Wrtie a New Article</h1>
        
        <div class="ui divider"></div>
        
        @include('errors.list')

        {!! Form::open(['url' => action('ArticlesController@index'), 'class' => 'ui form']) !!}
            @include('articles.form', ['submitButtonText' => 'Add a Article'])
        {!! Form::close() !!}
    </div>
 
@stop