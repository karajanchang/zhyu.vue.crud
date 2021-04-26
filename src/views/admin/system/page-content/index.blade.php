@extends('ZhyuVueCurd::layouts.base')


@push("css")
    <style>
        div.parent_relative{
            position: relative;
        }
        div.icon_plus_fixed{
            position: absolute;
            top: -30px;
            left:-30px;
        }
        .fa-plus-circle:hover{
            transform: scale(2);
        }
        .ck-editor__editable_inline {
            min-height: 400px;
            max-width: 85%;
        }
    </style>
@endpush

@push("js")
    <script src="/ckeditor3/ckeditor.js" type="text/javascript"></script>
    <script src="/ckeditor3/translations/zh.js"></script>
@endpush

@push("js_append")
    <script src="{{ asset('/assets/js/admin.js')}}" type="text/javascript"></script>
    <script src="{{ asset('/assets/js/form.js')}}" type="text/javascript"></script>
    <script>


        // let editor = ClassicEditor
        //     .create(document.querySelector(
        //         '#body'), {
        //         language: 'zh',


        // simpleUpload: {
        {{--    uploadUrl: '{{ route('vendor.ckeditor', ['table' => 'page_contents' ]) }}',--}}

        // Enable the XMLHttpRequest.withCredentials property.
        // withCredentials: false,

        // Headers sent along with the XMLHttpRequest to the upload server.
        // headers: {
        //     'X-CSRF-TOKEN': window.Laravel.csrfToken,
        // Authorization: 'Bearer <JSON Web Token>'
        // }
        //  },
        // .then(newEditor => {
        //     editor = newEditor
        //     console.log(editor);
        //  })
        //  .catch(error => {
        //      console.error(error);
        //  });
        // function openModal(){
        //     document.getElementById('modal').classList.add('is-active');
        // editor.setData('bbbbbbbbbbbbbbbbb');
        // }
        // document.querySelector( '.close-modal' ).addEventListener( 'click', () => {
        //     document.getElementById('modal').classList.remove('is-active');
        // });
        // document.querySelector( '.button-close-modal' ).addEventListener( 'click', () => {
        //     document.getElementById('modal').classList.remove('is-active');
        // });
        let params = [
            'height='+screen.height,
            'width='+screen.width,
            'fullscreen=yes' // only works in IE, but here for completeness
        ].join(',');
        function openFullWindow(url){
            let popup = window.open(url, 'popup_window', params);
            popup.moveTo(0,0);
        }




    </script>


@endpush


@section("content")
    <div id="app" class="container">
        <div class="buttons">
            <b-button type="is-primary" onclick="location.href='/admin/system/pagecontent/{{ $page->id }}/create'">新增版面</b-button>
        </div>


        @if($page->contents->count() > 0)
            @foreach($page->contents as $c)
                <section id="section-{{$c->id}}">
                    @if(!is_null($c->title)) <h1 class="title">{{ $c->title }}</h1> @endif
                    @if(!is_null($c->subtitle)) <h1 class="subtitle">{{ $c->subtitle }}</h1> @endif
                    @if($c->container==1) <div class="container"> @endif
                        <div class="columns
                        @if($c->is_vcentered==1) is-vcentered @endif
                        @if($c->is_multiline==1) is-multiline @endif
                        @if($c->is_centered==1) is-centered @endif
                        @if($c->is_fluid==1) is-fluid @endif
                                is-{{ $c->gap }}
                                ">
                            @foreach($c->columns as $column)
                                <div class="column is-{{ $column->size }} @if($column->has_text_centered==1) has-text-centered @endif" style="border:1px #ccc dashed;">
                                    <div class="parent_relative is-clickable" onclick="openFullWindow('{{ route('admin.system.pagecolumn.edit', ['page_content' => $c, 'page_column' => $column]) }}')">
                                        <div class="icon has-text-success icon_plus_fixed is-large">
                                            <i class="fas fa-plus-circle"></i>
                                        </div>
                                    </div>
                                    <div class="content">
                                        @if(!is_null($column->pic))
                                            @if(!is_null($column->url))
                                                <a href="{{ $column->url }}">
                                                    @endif
                                                    <b-image
                                                            src="{{ $column->pic }}"
                                                            alt="{{ $alt = !is_null($column->alt) ? $column->alt : 'picture'}}"
                                                            @if(!is_null($column->ratio))
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
                            @php
                                //dump($c->toArray());
                            @endphp
                        </div>
                        @if($c->container==1) </div> @endif
                </section>
            @endforeach
        @endif
    </div>

    {{--    <livewire:admin.config-list />--}}
@stop
