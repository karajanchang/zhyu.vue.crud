@extends('ZhyuVueCurd::layouts.base')


@push("js")

@endpush

@push("js_append")
    <script src="{{ asset('/assets/js/admin.js')}}" type="text/javascript"></script>
    <script src="{{ asset('/assets/js/form.js')}}" type="text/javascript"></script>
@endpush


@section("content")
    <div id="app" class="container">
        <livewire:admin.config-form :configs="$configs"/>
    </div>

@stop
