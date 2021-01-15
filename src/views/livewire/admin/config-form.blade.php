<div>
    <div class="buttons">
        <b-button type="is-default" onclick="location.href='/admin/system/config'">返回</b-button>
    </div>

    @if ($errors->any())
        <template>
            <section>
                <b-notification type="is-danger" role="alert" aria-close-label="Close notification">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </b-notification>
            </section>
        </template>
    @endif

    <template>
        <form wire:submit.prevent="submitConfigForm">

            <section>
                <div class="left">
                    <div class="level-item has-text-centered">
                        <b-field label="標籤" @error('configs.tag') type="is-danger"
                                 message="請輸入標籤" @enderror>
                            <b-input value="" name="tag" maxlength="30" wire:model="configs.tag"></b-input>
                        </b-field>
                    </div>

                    <div class="level-item has-text-centered">
                        <b-field label="顯示文字" @error('configs.ctitle') type="is-danger"
                                 message="請輸入顯示文字" @enderror>
                            <b-input value="" name="ctitle" maxlength="100" wire:model="configs.ctitle"></b-input>
                        </b-field>
                    </div>

                    <div class="level-item has-text-centered">
                        <b-field label="類別" @error('configs.type') type="is-danger"
                                 message="請選擇一種類別" @enderror>
                            <b-select placeholder="請選擇一種類別" required wire:model="configs.type">
                                <option value="1">文字</option>
                                <option value="2">檔案</option>
                                <option value="3">checkbox</option>
                                <option value="4">select</option>
                                <option value="5">radio</option>
                                <option value="6">Rich文字</option>
                                <option value="7">網址</option>
                            </b-select>
                        </b-field>
                    </div>
                    <div class="level-item has-text-centered m-3">
                        <b-button native-type="submit" type="is-info" label="送出"></b-button>
                    </div>
                </div>

            </section>
        </form>
    </template>
</div>

