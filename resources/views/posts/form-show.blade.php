
    <div class="ui threaded comments">
      
      <div class="comment owner">
        <a class="avatar">
          <img src="{{ $post->user->photo_link }}">
        </a>
        <div class="content">
          <a class="author" href="/user/{{ $post->user->name }}">{{ $post->user->name }}</a>
          <div class="metadata">
            <a style="color:inherit;" class="date popup" data-content="{{ $post->created_at->format('Y년 m월 d일 H시 i분') }}" data-variation="inverted">
              {{ $post->created_at->diffForHumans() }}
            </a>
          </div>
          <div class="text">
            {!! $post->content !!}
          </div>
          <div class="actions">
            @if( $post->edit_link ) <a href="{{ $post->edit_link }}"><i class="write icon"></i> 수정하기</a> @endif
            @if( $post->delete_link ) <a href="{{ $post->delete_link }}"><i class="trash icon"></i> 삭제하기</a> @endif
          </div>
        </div>
      </div>