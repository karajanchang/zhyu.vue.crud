@extends('layouts.page')

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

    <div id="app">
        @if($page->is_online==1)
            @php
                $pageContents = $page->contents;
            @endphp

            @if($pageContents->count() >0)
                @foreach($pageContents as $content)
                    <section class="section">
                        <h2 class="has-text-black has-text-left is-size-3">{{ $page->title ?? '' }}</h2>
                        @if(!is_null($content->subtitle)) <h3 class="subtitle">{{ $content->subtitle }}</h3> @endif
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
                                                {!! $column->body !!}
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
