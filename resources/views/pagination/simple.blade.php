@if ( method_exists( $paginator, 'lastPage' ) && $paginator->lastPage() > 1)
<div class="ui borderless four item menu">
    <a class="item {{ ($paginator->currentPage() == 1) ? ' disabled' : '' }}"
       href="{{ $paginator->url(1) }}">
        처음
    </a>
    <a class="item {{ ($paginator->currentPage() == 1) ? ' disabled' : '' }}"
       href="{{ $paginator->url( ($paginator->currentPage() < 2) ? 1 : $paginator->currentPage()-1) }}">
        이전
    </a>
    <a class="item {{ ($paginator->currentPage() == $paginator->lastPage()) ? ' disabled' : '' }}"
       href="{{ $paginator->url($paginator->currentPage()+1) }}">
        다음
    </a>
    <a class="item {{ ($paginator->currentPage() == $paginator->lastPage()) ? ' disabled' : '' }}"
       href="{{ $paginator->url($paginator->lastPage()) }}" >
        끝
    </a>
</div>
@endif