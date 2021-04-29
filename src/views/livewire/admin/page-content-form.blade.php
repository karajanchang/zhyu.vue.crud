
<div>

    <div class="buttons">
        <b-button type="is-default" onclick="location.href='{{ url(route('admin.system.pagecontent.index', [ 'page' => $page ])) }}'">返回</b-button>
    </div>

    <hr />
    <div class="title">版面設定</div>

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
        <form wire:submit.prevent="submitPageContentForm">

            <section>
                <div class="field">
                    <b-field label="類別" @error('page_content.column_nums') type="is-danger"
                             message="請選擇一種佈局" @enderror>
                        <b-select placeholder="選擇幾欄的部局" wire:model="page_content.column_nums" wire:change="changeColumnNums($event.target.value)">
                            <option value="1">1欄</option>
                            <option value="2">2欄</option>
                            <option value="3">3欄</option>
                            <option value="4">4欄</option>
                            <option value="5">5欄</option>
                            <option value="6">6欄</option>
                        </b-select>
                    </b-field>

                    <div class="columns mt-5" id="column_sizes">
                        @foreach($column_sizes as $key => $c)
                            <div class="column has-text-centered is-{{$c}}" style="border:1px solid #666666; background: #ccc">
                                <div>欄位{{ $key+1 }}大小</div>
                                <input type="number" wire:model="column_sizes.{{$key}}" value="{{ $c }}" style="border:1px solid #eee; width:100%" class="p-3 m-3"></input>
                            </div>
                        @endforeach
                    </div>



                    <b-field label="版面主標" @error('page_content.title') type="is-danger"
                             message="請輸入版面主標" @enderror>
                        <b-input name="title" maxlength="100" wire:model="page_content.title"></b-input>
                    </b-field>
                    <b-field label="版面副標" @error('page_content.subtitle') type="is-danger"
                             message="請輸入版面副標" @enderror>
                        <b-input name="subtitle" maxlength="100" wire:model="page_content.subtitle"></b-input>
                    </b-field>


                    <b-field label="排序" @error('page_content.subtitle') type="is-danger"
                             message="請輸入排序數字" @enderror>
                        <b-numberinput name="orderby" maxlength="9999" wire:model="page_content.orderby" size="is-small" controls-position="compact" controls-rounded type="is-warning"></b-numberinput>
                    </b-field>


                <!--div class="field is-horizontal is-grouped">

{{--                        @if($this->page_content->type==1 || $this->page_content->type==3)--}}
                        <b-field class="file is-primary">
                            <b-upload wire:model="page_content.pic" class="file-label">
                            <span class="file-cta">
                                <b-icon class="file-icon" icon="upload"></b-icon>
                                <span class="file-label">Click to upload</span>
                            </span>
                            </b-upload>
                        </b-field>
{{--                        @endif--}}
                        </div-->



                    <b-field label="間距" @error('page_content.gap') type="is-danger"
                             message="請選擇一種間距" @enderror>
                        <b-select placeholder="選擇間距" wire:model="page_content.gap" id="gap">
                            <option value="0">0</option>
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3 (預設值)</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                            <option value="6">6</option>
                            <option value="7">7</option>
                            <option value="8">8</option>
                        </b-select>
                    </b-field>


                    <b-field label="其他設定" class="mt-5">
                        <nav class="level">
                            <div class="level-item has-text-centered">
                                <div>
                                    <input type="checkbox" wire:model="page_content.is_vcentered">垂直對齊
                                </div>
                            </div>
                            <div class="level-item has-text-centered">
                                <div>
                                    <input type="checkbox" wire:model="page_content.is_centered">欄位置中
                                </div>
                            </div>
                            <div class="level-item has-text-centered">
                                <div>
                                    <input type="checkbox" wire:model="page_content.is_multiline" class="m-3">縮小時變多行
                                </div>
                            </div>
                            <div class="level-item has-text-centered">
                                <div>
                                    <input type="checkbox" wire:model="page_content.container">大螢幕維持固定寬度<br/>(1344px以下)
                                </div>
                            </div>
                            <div class="level-item has-text-centered">
                                <div>
                                    <input type="checkbox" wire:model="page_content.is_fluid">永遠使用最大寬度<br/>(永遠左右保持32px)
                                </div>
                            </div>

                        </nav>
                    </b-field>


                    <!--textarea id="body" style="height: 375px" wire:model.lazy="page_content.body" wire:ignore></textarea-->

                    <div class="buttons has-text-centered">
                        <b-button native-type="submit" type="is-info" label="送出" id="button"></b-button>
                    </div>
                </div>
            </section>
        </form>
    </template>
</div>

