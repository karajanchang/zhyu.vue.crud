@extends('ZhyuVueCurd::layouts.base')


@push("js")
    <script src="/ckeditor/ckeditor.js" type="text/javascript"></script>
    <script src="/ckeditor/translations/zh.js"></script>
@endpush

@push("js_append")
    <script src="{{ asset('/assets/js/admin.js')}}" type="text/javascript"></script>
    <script src="{{ asset('/assets/js/form.js')}}" type="text/javascript"></script>

    <script type="text/javascript">
        // ClassicEditor
        //     .create(document.querySelector(
        //         '#body'), {
        //         language: 'zh',
        /*
        ckfinder: {
            uploadUrl: '/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images&responseType=json'
        }
        */


        // simpleUpload: {
        // The URL that the images are uploaded to.
        {{--uploadUrl: '{{ route('vendor.ckeditor', ['table' => 'page_contents' ]) }}',--}}

        // Enable the XMLHttpRequest.withCredentials property.
        // withCredentials: false,

        // Headers sent along with the XMLHttpRequest to the upload server.
        // headers: {
        //     'X-CSRF-TOKEN': window.Laravel.csrfToken,
        // Authorization: 'Bearer <JSON Web Token>'
        // }
        // },
        /*
        toolbar:[
            'heading', '|',
            'bold', 'italic', 'strikethrough', 'underline', 'subscript', 'superscript', '|',
            'link', '|',
            'outdent', 'indent', '|',
            'bulletedList', 'numberedList', 'todoList', '|',
            'code', 'codeBlock', '|',
            'insertTable', '|',
            'imageUpload', 'blockQuote', '|',
            'undo', 'redo'
        ],*/
        // })
        // .then(newEditor => {
        //     editor = newEditor
        //     console.log(editor);
        // })
        // .catch(error => {
        //     console.error(error);
        // });


        // document.querySelector( '#button' ).addEventListener( 'click', () => {
        //     const editorData = editor.getData();
        //     console.log('11111111111'+editorData);
        //     Livewire.emit('submitPageContentForm', editorData);
        // });

        /*
        var quill = new Quill('#body', {
            modules: { toolbar: true },
            theme: 'snow'
        });
         */
        /*
        var quill = new Quill('#body', {
            modules: {
                toolbar: [
                    ['bold', 'italic', 'underline', 'strike'],        // toggled buttons
                    ['blockquote', 'code-block'],

                    [{ 'header': 1 }, { 'header': 2 }],               // custom button values
                    [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                    [{ 'script': 'sub'}, { 'script': 'super' }],      // superscript/subscript
                    [{ 'indent': '-1'}, { 'indent': '+1' }],          // outdent/indent
                    [{ 'direction': 'rtl' }],                         // text direction

                    [{ 'size': ['small', false, 'large', 'huge'] }],  // custom dropdown
                    [{ 'header': [1, 2, 3, 4, 5, 6, false] }],

                    [{ 'color': [] }, { 'background': [] }],          // dropdown with defaults from theme
                    [{ 'font': [] }],
                    [{ 'align': [] }],

                    ['clean']
                ]
            },
            theme: 'snow'  // or 'bubble'
        });
         */
        // document.querySelector( '#gap' ).addEventListener( 'change', () => {
        //     document.querySelector( '#column_sizes').classList.add('is-0');
        // column_sizes
        // });
    </script>
@endpush


@section("content")
    <div id="app" class="container">
        @livewire('admin.page-content-form', [ 'page' => $page])
    </div>



@stop
