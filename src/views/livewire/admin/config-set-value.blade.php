<div>
    @php
        $configs->typeWithName();
    @endphp
    <div class="title">設定名稱： {{ $configs->tag }} / {{ $configs->ctitle }}</div>
    <span class="subtitle">類別：{{ $configs->type }}</span>


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


        <form wire:submit.prevent="submitConfigSetValueForm">
            <div class="level">
                <div class="level-item">
                    <div class="field is-grouped">
                        <div class="block">
                            @if($configs->type==2)
{{--                                @if (is_object($value) && $is_uploaded===true)--}}
{{--                                    上傳檔案:--}}
{{--                                    <a href="{{ $value->temporaryUrl() }}" target="_blank">預覽</a>--}}
{{--                                @endif--}}
                                @if(is_string($value))
                                    <div class="m-5">
                                        <a href="{{Storage::url($value)}}" target="_blank">按下來預覽</a>
                                    </div>
                                @endif
                                <b-upload wire:model="value" drag-drop expanded class="has-background-info-light">
                                    <section class="section">
                                        <div class="content has-text-centered">
                                            <p>
                                                <b-icon icon="upload" size="is-large"></b-icon>
                                            </p>
                                            <p>Drop your files here or click to upload</p>
                                        </div>
                                    </section>
                                </b-upload>
                            @elseif($configs->type==3)
                                @foreach($configValues as $key => $configValue)
                                    <b-checkbox wire:model="value" native-value="{{ $configValue['value'] }}">
                                        {{ $configValue['value'] }}
                                    </b-checkbox>
                                @endforeach
                            @elseif($configs->type==5)
                                @foreach($configValues as $key => $configValue)
                                    <b-radio wire:model="value" native-value="{{ $configValue['value'] }}">
                                        {{ $configValue['value'] }}
                                    </b-radio>
                                @endforeach
                            @else
                                <b-input wire:model="value" native-value="{{ $configs->value }}">
                            @endif
                        </div>
                    </div>
                </div>
            </div>


                <div class="field">
                    <p class="control is-expanded has-text-centered">
                        <b-button native-type="submit" type="is-info" label="送出"></b-button>
                    </p>
                </div>
        </form>
    </div>
</div>
