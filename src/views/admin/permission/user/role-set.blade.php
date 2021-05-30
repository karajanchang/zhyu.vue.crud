@extends('ZhyuVueCurd::layouts.base')

@push("js")
    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.8.0/dist/alpine.min.js" defer></script>
@endpush
@php
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
            <b-button type="is-default" onclick="location.href='{{ route('admin.permission.user.index') }}'">返回</b-button>
        </div>
        @if($errors->any())
            <b-message title="Danger" type="is-danger" aria-close-label="Close message">
                <h4>{{$errors->first()}}</h4>
            </b-message>
        @endif

        <div class="title">設定 {{ $user->slug }} "{{$user->name }}" 的角色</div>

        <section>
            <form action="{{ route('admin.permission.user.role.save', ['user' => $user]) }}" method="post">
                @method('PATCH')
                <div class="field">
                    <label class="label">角色</label>
                    <div class="control">
                        <div class="select">
                            <select name="role_id">
                                <option value="0">-</option>
                                @foreach($roles as $role)
                                    <option value="{{ $role->id }}" @if($role->slug == $teamRole) selected @endif>{{ $role->name }}</option>
                                @endforeach
                            </select>
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
