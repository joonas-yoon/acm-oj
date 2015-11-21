@if ($paginator->lastPage() > 1)
<div class="ui borderless menu">
    <a class="item {{ ($paginator->currentPage() == 1) ? ' disabled' : '' }}"
       href="{{ $paginator->url(1) }}">
        처음
    </a>

    <!-- 페이지 이동 중에 채점 번호가 밀려 페이지도 밀리므로 -->
    <!-- 현재까지 표시한 채점번호를 기준으로 이동해야함 -->
    <a class="item"
       href="#">
       이전
    </a>

    <a class="item"
       href="#">
       다음
    </a>

    <a class="item {{ ($paginator->currentPage() == $paginator->lastPage()) ? ' disabled' : '' }}"
       href="{{ $paginator->url($paginator->currentPage()+1) }}" >
        끝
    </a>
</div>
@endif