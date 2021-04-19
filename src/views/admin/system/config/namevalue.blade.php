@extends('ZhyuVueCurd::layouts.base')


@push("js")

@endpush

@push("js_append")
    <script src="{{ asset('/assets/js/admin.js')}}" type="text/javascript"></script>
    <script src="{{ asset('/assets/js/form.js')}}" type="text/javascript"></script>
@endpush


@section("content")

    <div id="app" class="container">
        <b-button type="is-default" onclick="location.href='{{ route('admin.system.config.index') }}'">返回</b-button>
        
        <livewire:admin.config-name-value :configs="$configs"/>
    </div>

@stop
