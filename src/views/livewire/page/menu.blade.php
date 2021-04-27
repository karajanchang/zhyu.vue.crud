<section class="m-3 is-hidden-mobile">
    <div class="container is-fluid has-text-centered is-size-5">
        @if($menus->count() > 0)
            @foreach($menus as $menu)
                @php
                    $first_word = substr($menu->url, 0, 1);
                    $uri = $menu->url;
                    if($first_word=='/'){
                        $uri = substr($menu->url, 1, strlen($menu->url));
                    }
                @endphp
                <a href="@if(\Request::is($uri)) # @else {{ $menu->url }} @endif" aria-label="{{ $menu->ctitle }}" class="m-5 has-text-black-ter">{{ $menu->ctitle }}</a>
            @endforeach
        @endif
    </div>
</section>
