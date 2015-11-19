<li {!! $item->hasChildren() ? 'class="dropdown panel panel-default"' : null !!}
    {!! Request::url() == $item->url() ? 'class="active"' : null !!} >

    <a {!! $item->hasChildren() ? 'data-toggle="collapse" href="#collapse'.$item->slug.'"' : 'href="'.$item->url().'"' !!} >
        {!! $item->title !!}
    </a>

    @if ($item->hasChildren())
        <div id="collapse{{$item->slug}}" class="panel-collapse collapse">
            <div class="panel-body">
                <ul class="nav navbar-nav">
                     @foreach ($item->children() as $child)
                        <li {!! Request::url() == $child->url() ? 'class="active"' : null !!}>
                            <a href="{{ $child->url() }}">{{ $child->title }}</a>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif

</li>