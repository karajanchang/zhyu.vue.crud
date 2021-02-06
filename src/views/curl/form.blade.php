@extends('ZhyuVueCurd::layouts.base')


@push("js")

@endpush

@push("js_append")

    <script type="text/javascript">
        {!! $tableService->js() !!}
    </script>

    <script src="/ckeditor/ckeditor.js"></script>
    <script src="/ckeditor/translations/zh-TW.js"></script>

    <script src="{{ asset('/assets/js/form.js')}}" type="text/javascript"></script>



    <script type="text/javascript">
        {!! $tableService->js2() !!}
    </script>

@endpush


@section("content")
    <div id="app" class="container">
        <section>
            {!! $tableService->table() !!}
        </section>
    </div>

    <script src="/assets/js/date.js"></script>
@stop
