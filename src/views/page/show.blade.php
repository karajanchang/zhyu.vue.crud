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
    @livewire('page-menu', [ 'page' => $page])

    @if(($page->is_online==0 || $preview===true) && Auth::check())
        <div style="background-color: #666; position: fixed; top: 100px; right: 0; z-index: 9999; " class="m-5 p-5 has-text-white-ter is-size-2">預覽模式</div>
    @endif

    <div id="app" >
        @if(Auth::check() || $page->is_online==1 || $preview===true)
            @php
                $pageContents = $page->contents;
            @endphp

            @if($pageContents->count() >0)
                @foreach($pageContents as $content)
                    <section class="section">
                        <h2 class="has-text-black has-text-left is-size-3"><b-icon icon="view-dashboard" size="is-tiny" type="is-info"></b-icon>{{ $page->title ?? '' }}</h2>
                        @if(!is_null($content->title)) <h3 class="subtitle">{{ $content->title }} @if(!is_null($content->subtitle)) <span style="font-size: 0.75em">{{ $content->subtitle }}</span> @endif</h3> @endif

                        @if($content->container==1) <div class="container"> @endif
                            <hr style="border-top: 1px solid black;">

                            <div class="columns"
                                 @if($content->is_vcentered==1) is-vcentered @endif
                                 @if($content->is_multiline==1) is-multiline @endif
                                 @if($content->is_centered==1) is-centered @endif
                                 @if($content->is_fluid==1) is-fluid @endif
                                 is-{{ $content->gap }}
                            >
                                @foreach($content->columns as $column)
                                    <div class="column is-{{ $column->size }} @if($column->has_text_centered==1) has-text-centered @endif">
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
                            @if($content->container==1) </div> @endif
                    </section>
                @endforeach
            @else
                <div class="notification is-danger">
                    目前頁面無任務內容
                </div>
            @endif
        @else
            <div class="notification is-danger">
                目前頁面下架中
            </div>
        @endif
    </div>

@stop
