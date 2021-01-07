@if(is_array($parents))
    @php
        $key=0;
        $length = count($parents);
        krsort($parents);
        $url = url(route('admin.system.menu.index'));
    @endphp
    <nav class="breadcrumb" aria-label="breadcrumbs">
        <ul>
            <li><a href="{{ $url }}">選單管理</a></li>

                @foreach($parents as $menu)
                    @if($key==$length-1)
                        <li class="is-active"><a href="#" aria-current="page">{{ $menu->title }}&nbsp;({{ $menu->ctitle }})</a></li>
                    @else
                        <li><a href="{{ $url }}?parent_id={{$menu->id}}">{{ $menu->title }}&nbsp;({{ $menu->ctitle }})</a></li>
                    @endif

                    @php
                        $key++;
                    @endphp
                @endforeach
        </ul>
    </nav>
@endif
