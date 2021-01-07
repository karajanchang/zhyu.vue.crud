<div>
    @php
        $configs->typeWithName();
    @endphp
    <div class="title">設定名稱： {{ $configs->tag }} / {{ $configs->ctitle }}</div>
    <span class="subtitle">類別：{{ $configs->type }}</span>

    <div class="has-text-right"><b-button type="is-info" label="增加屬性 (+)" wire:click="increment" class="is-small is-m5"></b-button></div>

    <div class="m-5">

        <div>
            @if (session()->has('success_message'))
                <b-notification
                    type="is-success"
                    has-icon
                    aria-close-label="Close notification" closable class="m-5">
                    {{ session('success_message') }}
                </b-notification>
            @endif
        </div>

        <div>
            @if (session()->has('fail_message'))
                <b-notification
                    type="is-danger"
                    has-icon
                    aria-close-label="Close notification" closable class="m-5">
                    {{ session('fail_message') }}
                </b-notification>
            @endif
        </div>


        <form wire:submit.prevent="submitConfigNameValueForm">
            @for($i=0;$i<$counter;$i++)
                <div class="field is-horizontal is-grouped">
                    <div class="field-label is-normal">
                        <label class="label">{{ $i+1 }}</label>
                    </div>
                    <div class="field-body">
                        <div class="field">
                            <p class="control is-expanded has-icons-left">
                                <input class="input" type="text" placeholder="名稱" wire:model="configValues.{{$i}}.name">
                            </p>
                        </div>
                        <div class="field">
                            <p class="control is-expanded has-icons-left">
                                <input class="input" type="text" placeholder="值" wire:model="configValues.{{$i}}.value">
                            </p>
                        </div>
                    </div>
                </div>
            @endfor
            <div class="field">
                <p class="control is-expanded has-text-centered">
                    <b-button native-type="submit" type="is-info" label="送出"></b-button>
                </p>
            </div>
        </form>
    </div>
</div>
