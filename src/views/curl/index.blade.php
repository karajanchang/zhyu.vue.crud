@extends('vendor.layouts.base')

@push("js")
    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.8.0/dist/alpine.min.js" defer></script>
@endpush
@php
    $all = \Request::all();
    $queryString = urlencode(\Zhyu\Facades\ZhyuTool::urlMakeQuery('#')->encode($all));
@endphp
@push("js_append")
    <script>
        // Livewire.on('draggIt', data => {
        //     alert('A post was added with the id of: ');
        // })
        window.queryString = '{{$queryString}}';
    </script>

    <script src="{{ asset('/js/datatable.js')}}"></script>

@endpush


@section("content")
    <div id="app" class="container">
        <div class="buttons">
            @if(!is_null($urls['create']))
                @if(!is_null($parent_id) && (int) $parent_id >0 )
                    <b-button type="is-primary" onclick="location.href='{{ $urls['create'] }}?parent_id={{$parent_id}}'">新增</b-button>
                @else
                    <b-button type="is-primary" onclick="location.href='{{ $urls['create'] }}'">新增</b-button>
                @endif
            @endif
        </div>

        @livewire('admin.menu-breadcrumb', ['parent_id' => $parent_id])

    @livewire('admin.table-row-drag', ['model' => $tableService->model, 'parent_id' => $parent_id])

    {!! $tableService->table() !!}


    </div>

@stop
