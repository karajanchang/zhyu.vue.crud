@extends('ZhyuVueCurd::layouts.base')


@push("js")
    <script src="/ckeditor/ckeditor.js" type="text/javascript"></script>
    <script src="/ckeditor/translations/zh.js"></script>
@endpush

@push("js_append")
    <script src="{{ asset('/assets/js/admin.js')}}" type="text/javascript"></script>
    <script src="{{ asset('/assets/js/form.js')}}" type="text/javascript"></script>

    <script type="text/javascript">

    </script>
@endpush


@section("content")
    <div id="app" class="container">
        <div class="title" style="display: inline-block">{{ $page->title }}</div> &gt;&gt;左選單

        @livewire('admin.page-arrangement', [ 'page' => $page])
    </div>



@stop
