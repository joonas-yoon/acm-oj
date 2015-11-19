    
    <div class="field">
         {!! Form::label('title', 'Title') !!}
         {!! Form::text('title') !!}
    </div>

    <div class="field">
         {!! Form::label('body', 'Body') !!}
         {!! Form::textarea('body') !!}
    </div>

    <div class="field">
         {!! Form::label('published_at', 'Publish on') !!}
         {!! Form::input('date', 'published_at', date('Y-m-d')) !!}
    </div>

    {!! Form::submit($submitButtonText, ['class' => 'ui button']) !!}