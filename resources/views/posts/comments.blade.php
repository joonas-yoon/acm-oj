@if( isset($parent) && $parent->comments )

    <div class="ui threaded comments">
        
      @forelse($parent->comments as $comment)
      <div class="comment {{ isset($post->user) && $post->user->name == $comment->user->name ? 'owner':'' }}">
        <a class="avatar">
          <img src="{{ $comment->user->photo_link }}">
        </a>
        <div class="content">
          <a class="author" href="/user/{{ $comment->user->name }}">{{ $comment->user->name }}</a>
          <div class="metadata">
            <a style="color:inherit;" class="date popup" data-content="{{ $comment->created_at->format('Y년 m월 d일 H시 i분') }}" data-variation="inverted">
              {{ $comment->created_at->diffForHumans() }}
            </a>
          </div>
          <div class="text">
            {!! $comment->content !!}
          </div>
        </div>
      </div>
      @empty
      <p align="center" style="color:#999;padding:1em 0;">
        표시할 댓글이 없습니다.
      </p>
      @endforelse
      
      @if( Sentinel::check() )
      {!! Form::open(['url' => action('PostsController@storeComment'), 'method' => 'PUT', 'class'=>'ui form']) !!}
      {!! Form::hidden('parent_id', $parent->id) !!}
      @if( isset($parent_on) )
      {!! Form::hidden('parent_on', $parent_on) !!}
      @endif
      
      @include('errors.list')
        
      <div class="comment">
        <a class="avatar">
          <img src="{{ Sentinel::getUser()->photo_link }}">
        </a>
        <div class="content">
          <div class="text">
            <textarea id="editor" name="content" class="html-editor-simple">
              {!! old('content') !!}
            </textarea>
          </div>
          <button type="submit" class="ui blue labeled submit icon button">
            <i class="icon edit"></i> 댓글 쓰기
          </button>
        </div>
      </div>
      {!! Form::close() !!}
      @else
      <div class="ui divider"></div>
      <a href="/login" class="ui blue labeled submit icon button">
        <i class="icon edit"></i> 댓글 쓰기
      </a>
      @endif
    </div>
    
@else
<p align="center" style="color:#999;padding:1em 0;">
  댓글을 표시할 수 없습니다.
</p>
@endif
