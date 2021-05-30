@extends('ZhyuVueCurd::layouts.base')

@push("js")
    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.8.0/dist/alpine.min.js" defer></script>
@endpush
@php
    $actions = [
        'create' => '新增', 'read' => '讀取', 'update' => '修改', 'delete' => '刪除',
    ];
@endphp
@push("js_append")
    <script>
        // Livewire.on('draggIt', data => {
        //     alert('A post was added with the id of: ');
        // })
    </script>

    <script src="{{ asset('/assets/js/admin.js')}}" type="text/javascript"></script>
    <script src="{{ asset('/assets/js/form.js')}}" type="text/javascript"></script>

@endpush


@section("content")
    <div id="app" class="container">
        <div class="buttons">
            <b-button type="is-default" onclick="location.href='{{ route('admin.permission.role.index') }}'">返回</b-button>
        </div>

        @if($errors->any())
            <b-message title="Danger" type="is-danger" aria-close-label="Close message">
                <h4>{{$errors->first()}}</h4>
            </b-message>
        @endif


        <div class="title">設定 {{ $role->slug }} "{{$role->name }}" 的權限</div>

        <section>
            <form action="{{ route('admin.permission.role.permission.save', ['role' => $role]) }}" method="post">
                @method('PATCH')
                <div class="field">
                    <label class="label">資源</label>
                    <div class="control">
                        <div class="checkbox">
                            <ol>
                                @foreach($resources as $resource)
                                    <li>
                                        <div class="title">{{ $resource->name }}</div>
                                        @php
                                            $checkeds = [];
                                            $pms = $permissions->where('resource_id', $resource->id);
                                            if($pms->count() > 0){
                                                $pm = $pms->first();
                                                $checkeds = json_decode($pm->acts);
                                            }
                                        @endphp
                                        @foreach($actions as $action => $action_name)

                                            <input type="checkbox" name="resource_id[{{ $resource->id }}][]" value="{{ $action }}" @if(in_array($action, $checkeds)) checked @endif />{{ $action_name }}
                                        @endforeach
                                    </li>
                                @endforeach
                            </ol>
                        </div>
                    </div>
                </div>
                <div class="field is-grouped">
                    <div class="control">
                        <button class="button is-info" type="submit">送出</button>
                    </div>
                    <div class="control">
                        <button class="button is-default is-light" onclick="history.back()" type="button">取消</button>
                    </div>
                </div>
                @csrf
            </form>
        </section>



    </div>

@stop
