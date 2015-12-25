
  <div class="ui top attached tabular menu">
    <a class="item {{ active_class( if_route(['posts.list']) ) }}" href="/posts/list">게시판 전체</a>
    <a class="item" href="/posts/list/1">자유</a>
    <a class="item {{ active_class( if_route(['posts.create']) ) }}" href="/posts/create">글쓰기</a>
  </div>