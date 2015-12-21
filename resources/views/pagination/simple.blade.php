@if( method_exists( $paginator, 'lastPage' ) && $paginator->lastPage() > 1 )
<div class="ui borderless four item menu">
    <a class="item {{ ($paginator->currentPage() == 1) ? ' disabled' : '' }}"
       href="{{ URL::current() . '?' . paging_query(Request::getQueryString(), 1) }}">
        처음
    </a>
    <a class="item {{ ($paginator->currentPage() == 1) ? ' disabled' : '' }}"
       href="{{ URL::current() . '?' . paging_query(Request::getQueryString(), $paginator->currentPage()-1, $paginator->lastPage()) }}">
        이전
    </a>
    <a class="item {{ ($paginator->currentPage() == $paginator->lastPage()) ? ' disabled' : '' }}"
       href="{{ URL::current() . '?' . paging_query(Request::getQueryString(), $paginator->currentPage()+1, $paginator->lastPage()) }}">
        다음
    </a>
    <a class="item {{ ($paginator->currentPage() == $paginator->lastPage()) ? ' disabled' : '' }}"
       href="{{ URL::current() . '?' . paging_query(Request::getQueryString(), $paginator->lastPage()) }}" >
        끝
    </a>
</div>
@endif