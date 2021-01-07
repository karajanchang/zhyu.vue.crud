<div id="navbar-menu" class="navbar-menu is-size-5">
    {{-- The whole world belongs to you --}}
    @foreach($menus as $menu)
        @if($menu->children->count() > 0)
            <div class="navbar-item has-dropdown is-uppercase is-hoverable">
                <a class="navbar-link" tabindex="0" aria-label="{{ $menu->ctitle }}">
                    {{ $menu->ctitle }}
                </a>

                <div class="navbar-dropdown is-size-5">
                    @foreach($menu->children as $child)
                        <a href="{{ $child->url }}" class="navbar-item is-uppercase" tabindex="0" aria-label="{{ $child->ctitle }}">
                            {{$child->ctitle}}
                        </a>
                    @endforeach
                </div>
            </div>
        @else
            <a href="{{ $menu->url }}" class="navbar-item is-uppercase" aria-label="{{ $menu->ctitle }}">
                {{ $menu->ctitle }}
            </a>
        @endif
    @endforeach
</div>
