<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="x-ua-compatible" content="ie=edge">

    <title>{{ env('APP_NAME') }} 後台管理</title>

    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css')  }}">
    <!-- IonIcons -->
    <link rel="stylesheet" href="http://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('vendor/css/adminlte.min.css')}}">
    <!-- buefy--->
    <link rel="stylesheet" href="https://cdn.materialdesignicons.com/5.3.45/css/materialdesignicons.min.css">
    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">



    <link rel="stylesheet" href="{{ asset('/assets/css/app.css')}}">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.2/css/bulma.min.css">



    <script src="/ckeditor3/ckeditor.js" type="text/javascript"></script>
    <script src="/ckeditor3/translations/zh.js"></script>

    <style>
        .ck.ck-editor {

            height: 400px;
            margin: 0 auto;
        }
        .ck-editor__editable_inline {
            min-height: 400px;
        }
        .w80{
            width:80%;
            margin: 0 auto;
        }
        .input{
            border:1px #ccc solid;
        }
        .input{
            padding: 3px;
            margin-top: 5px;
            margin-bottom: 5px;
            width:320px;
        }
        .input:hover, focus{
            width: 400px;
            transition: 0.3s;
            opacity: 0.7;
            color: #666666;
        }
        .inputPre{
            width: auto;
            display: inline-block;
        }
    </style>
    <script type="text/javascript">
        window.Laravel = { "csrfToken": "{{ csrf_token() }}"};
    </script>

</head>
<body>
    <section id="app" class="section p-5">
        <div class="container">
                <form enctype="multipart/form-data" action="{{ route('admin.system.pagecolumn.save', [ 'page_content' => $pageContent , 'page_column' => $pageColumn ]) }}" method="POST">
                    <div>
                        <div class="buttons" style="width:200px;margin:0 auto">
                            <button class="button is-default close-window" type="button">關閉視窗，重新整理</button>
                        </div>
                    </div>

                    <div class="block m-10 p-10 rounded-full"  style="background-color: #c8eed6">
                        <div class="title">欄位設定</div>
                        <div class="control w80">
                            <div class="inputPre">
                                欄位大小
                            </div>
                            <input class="input" type="text" name="size" placeholder="請輸入欄位大小 1-12數字（必填）" value="{{ $pageColumn->size }}"required>
                        </div>

                        <div class="control w80">
                            <label class="checkbox">
                                <input type="checkbox" name="has_text_centered" @if($pageColumn->has_text_centered==1) checked @endif value="1">文字置中
                            </label>
                        </div>

                    </div>
                    <div class="block m-10 p-10 rounded"  style="background-color: #eee">
                        <div class="title">圖片</div>
                        <div class="file w80">
                            <input  type="file" name="pic" id="pic">
                            <label class="file-label">
{{--                                <input class="file-input" type="file" name="pic" id="pic">--}}
                                <span class="file-cta">
                                    <span class="file-icon">
                                        <i class="fas fa-upload"></i>
                                    </span>
                                    <span class="file-label">選擇圖片</span>
                                </span>
                            </label>
                        </div>

                        @if(!is_null($pageColumn->pic))
                            <img src="{{ $pageColumn->pic }}" />
                        @endif

                        <div class="control w80">
                            <div class="inputPre">
                                圖片註解
                            </div>
                            <input class="input" type="text" name="alt" id="alt" placeholder="請輸入圖片註解（必填）" value="{{ $pageColumn->alt }}">
                        </div>
                        <div class="control w80">
                            <div class="inputPre">
                                圖片連結
                            </div>
                            <input class="input" type="text" name="url" placeholder="請輸入圖片連結網址" value="{{ $pageColumn->url }}">
                        </div>
                        <div class="control w80">
                            <div class="inputPre">
                                圖片比率
                            </div>
                            <input class="input" type="text" name="ratio" placeholder="請輸入圖片比率（3by4 / 4by6 / 4by3 ...）" value="{{ $pageColumn->ratio }}">
                        </div>
                        <div class="control w80">
                            <label class="checkbox">
                                <input type="checkbox" name="rounded" placeholder="" @if($pageColumn->rounded==1) checked @endif value="1">是否圓角
                            </label>
                        </div>
                    </div>

                    <div>
                        <div class="block m-10 p-10"  style="background-color: #fff">
                            <div class="title">內容</div>
                            <textarea id="body" name="body" class="body">{{ $pageColumn->body }}</textarea>
                        </div>

                        <div class="buttons" style="width:300px;margin:0 auto">
                            <button class="button is-link" type="submit">送出</button>
                            <button class="button is-default close-window" type="button">關閉視窗，重新整理</button>
                        </div>
                    </div>
                    @csrf
                </form>
        </div>
    </section>

    <script>
        ClassicEditor
            .create(document.querySelector('#body'), {
                language: 'zh',

                simpleUpload: {
                    uploadUrl: '{{ route('vendor.ckeditor', ['table' => 'page_columns' ]) }}',
                    // Enable the XMLHttpRequest.withCredentials property.
                    // withCredentials: false,
                    // Headers sent along with the XMLHttpRequest to the upload server.
                    headers: {
                        'X-CSRF-TOKEN': window.Laravel.csrfToken
                        // Authorization: 'Bearer <JSON Web Token>'
                    }
                }
            })
            .then(newEditor => {
                editor = newEditor
                console.log(editor);
            })
            .catch(error => {
                console.error(error);
            });


        let elements = document.querySelectorAll( '.close-window');
        for(var i=0; i<elements.length; i++) {
            elements[i].addEventListener('click', () => {
                opener.window.location.href = opener.window.location.href;
                window.close();
            });
        }
        // let pic = ducument.getElementById('pic');
        // pic.addEventListener('change', function () {
        //     document.getElementById('alt').required = true;
        // });
    </script>
</body>
