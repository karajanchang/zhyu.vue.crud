<section class="is-hidden-mobile">
    <div class="p-1 is-pulled-right">
        <div class="container is-fluid is-size-6">
            @if($menus->count() > 0)
                @foreach($menus as $menu)
                    @php
                        $first_word = substr($menu->url, 0, 1);
                        $uri = $menu->url;
                        if($first_word=='/'){
                            $uri = substr($menu->url, 1, strlen($menu->url));
                        }
                    @endphp
                    <a href="@if(\Request::is($uri)) # @else {{ $menu->url }} @endif" aria-label="{{ $menu->ctitle }}" class="m-2 has-text-black-ter">{{ $menu->ctitle }}</a>
                @endforeach
            @endif
        </div>
    </div>
</section>
