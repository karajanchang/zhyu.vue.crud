<div class="column is-3" id="top-head-nav">
    @if($menus->count() >0)
        @foreach ($menus as $menu)
            <a aria-label="{{ $menu->ctitle }}" href="{{ $menu->url }}" tabindex="0">{{$menu->ctitle}}</a>
        @endforeach
    @endif
</div>
