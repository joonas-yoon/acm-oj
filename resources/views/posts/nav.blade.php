
<div class="ui top attached tabular menu">
  <a class="item {{ active_class( if_uri(['posts']) ) }}" href="/posts">게시판 전체</a>
  <a class="item {{ active_class( if_route(['posts.write']) ) }}" href="/posts/create">글쓰기</a>
</div>