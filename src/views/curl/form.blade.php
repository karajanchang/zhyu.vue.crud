@extends('ZhyuVueCurd::layouts.base')


@push("css")
    <link rel="stylesheet" href="{{ asset('css/froala_editor.pkgd.min.css')  }}">
    <style>
        #app img{
            width: 400px !important;
        }
    </style>
@endpush

@push("js_append")

    <script type="text/javascript">
        {!! $tableService->js() !!}
    </script>

    @if(env('WYSIWYG_EDITOR', 'froala')=='ckeditor')
        <script src="/ckeditor/ckeditor.js"></script>
        <script src="/ckeditor/translations/zh-TW.js"></script>
    @else
        <script type="text/javascript" src="{{ asset('js/froala_editor/froala_editor.pkgd.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('js/froala_editor/languages/zh_tw.js') }}"></script>
    @endif

    <script type="text/javascript">
        {!! $tableService->js2() !!}
    </script>


    <script src="{{ asset('/assets/js/form.js')}}" type="text/javascript"></script>



@endpush


@section("content")
    <div id="app" class="container">
        <section>
            {!! $tableService->table() !!}
        </section>
    </div>

    <script src="/assets/js/date.js"></script>
@stop
