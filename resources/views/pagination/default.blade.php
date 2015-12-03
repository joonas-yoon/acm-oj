@if ( method_exists( $paginator, 'lastPage' ) && $paginator->lastPage() > 1)
<div class="ui borderless stacked menu">
    <a class="item {{ ($paginator->currentPage() == 1) ? ' disabled' : '' }}"
       href="{{ $paginator->url(1) }}">
        처음
    </a>

    @for ($i = 1; $i <= $paginator->lastPage(); $i++)
      <a class="item {{ ($paginator->currentPage() == $i) ? ' active' : '' }}"
         href="{{ $paginator->url($i) }}">
        {{ $i }}
      </a>
    @endfor

    <a class="item {{ ($paginator->currentPage() == $paginator->lastPage()) ? ' disabled' : '' }}"
       href="{{ $paginator->url($paginator->lastPage()) }}" >
        끝
    </a>
</div>
@endif