@php
    $layout = 'page';
    if(isset($page->layout) && !empty($page->layout)){
        $layout = $page->layout;
    }
@endphp

@extends('layouts.'.$layout)

@push("css")
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.2/css/bulma.min.css">
    <style>
        i.icon-black {
            color: black;
        }
    </style>

@endpush

@push("js_append")

    <script src="/js/empty.js"></script>

@endpush

@section("content")
    @if(isset($page->id))
        @if(($page->is_online==0 || $preview===true) && Auth::check())
            <div style="background-color: #666; position: fixed; top: 100px; right: 0; z-index: 9999; " class="m-5 p-5 has-text-white-ter is-size-2">預覽模式</div>
        @endif

        <div id="app" style="position: relative; top: -20px;">
            @if(Auth::check() || $page->is_online==1 || $preview===true)
                @php
                    $pageContents = $page->contents;
                @endphp

                @if($pageContents->count() >0)
                    @foreach($pageContents as $key => $content)
                        <section class="section">


                            @if($content->container==1) <div class="container"> @endif
                                {{--                            <hr style="border-top: 1px solid black;">--}}
                                @if(!empty($page->left_menu_id))
                                    @inject('menuRepository', \ZhyuVueCurd\Repositories\Admin\System\MenuRepository::class)
                                    @php
                                        $first_left_menu = null;
                                        $left_menus = $menuRepository->menusByParentId($page->left_menu_id);
                                    @endphp
                                    <div class="columns">
                                        <div class="column is-one-fifth">
                                            <section class="section">
                                                <ol style="list-style: none">
                                                    @if($key==0)
                                                        @foreach($left_menus as $left_menu)
                                                            @php
                                                                if(is_null($first_left_menu)){
                                                                    $first_left_menu = $left_menu;
                                                                }
                                                            @endphp
                                                            <li class="mb-2"><a href="{{ $left_menu->url }}" class="has-text-grey">{{ $left_menu->ctitle }}</a></li>
                                                        @endforeach
                                                    @endif
                                                </ol>


                                            </section>
                                            @if($key==0 && !empty($first_left_menu->parent->bottom_text))
                                                <section class="has-background-info-dark p-5 mt-3 is-size-4 has-text-white has-text-centered">
                                                    {{ $first_left_menu->parent->bottom_text ?? '' }}
                                                </section>
                                            @endif
                                        </div>

                                        <div class="column">
                                            @endif
                                            @if($key==0)
                                                <h2 class="has-text-black has-text-left is-size-3 m-3"><b-icon icon="view-dashboard" size="is-tiny" type="is-info"></b-icon>{{ $page->title ?? '' }}</h2>
                                            @endif


                                            <div class="columns"
                                                 @if($content->is_vcentered==1) is-vcentered @endif
                                                 @if($content->is_multiline==1) is-multiline @endif
                                                 @if($content->is_centered==1) is-centered @endif
                                                 @if($content->is_fluid==1) is-fluid @endif
                                                 is-{{ $content->gap }}
                                            >
                                                @foreach($content->columns as $column)
                                                    <div class="column is-{{ $column->size }} @if($column->has_text_centered==1) has-text-centered @endif">
                                                        @if(!is_null($content->title)) <h3 class="subtitle">{{ $content->title }} @if(!is_null($content->subtitle)) <span style="font-size: 0.75em">{{ $content->subtitle }}</span> @endif</h3> @endif
                                                        <div class="content">
                                                            @if(!is_null($column->pic))
                                                                @if(!is_null($column->url))
                                                                    <a href="{{ $column->url }}">
                                                                        @endif

                                                                        <b-image
                                                                                src="{{ asset('storage/'.$column->pic) }}"
                                                                                alt="{{ $alt = !is_null($column->alt) ? $column->alt : 'picture'}}"
                                                                                @if(!is_null($column->ratio))
                                                                                @if(isset($column->width)) width="{{ $column->width }}" @endif
                                                                                @if(isset($column->height)) height="{{ $column->height }}" @endif
                                                                                ratio="{{ $column->ratio }}"
                                                                                @endif
                                                                                @if($column->rounded==1)
                                                                                rounded="true"
                                                                                @endif
                                                                        ></b-image>
                                                                        @if(!is_null($column->url))
                                                                    </a>
                                                                @endif
                                                            @endif
                                                            <div class="block">
                                                                {!! str_replace(forala_front, '', $column->body) !!}
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>


                                            @if($key==0 && !empty($page->left_menu_id))

                                        </div>
                                    </div>
                                @endif
                                @if($content->container==1) </div> @endif
                        </section>
                    @endforeach
                @else
                    <div class="notification is-danger">
                        目前頁面無任何內容
                    </div>
                @endif
            @else
                <div class="notification is-danger">
                    目前頁面下架中
                </div>
            @endif
        </div>
    @else
        <div class="notification is-danger">
            目前頁面無任何內容
        </div>
    @endif

@stop
