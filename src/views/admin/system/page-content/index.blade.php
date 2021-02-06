@extends('ZhyuVueCurd::layouts.base')


@push("js")

@endpush

@push("js_append")
    <script src="{{ asset('/assets/js/form.js')}}" type="text/javascript"></script>
@endpush


@section("content")
    <div id="app" class="container">
        <div class="buttons">
            <b-button type="is-primary" onclick="location.href='/admin/system/pagecontent/{{ $page->id }}/create'">新增版面</b-button>
        </div>

    </div>

{{--    <livewire:admin.config-list />--}}
@stop
