<div>

    <div class="buttons">
        <b-button type="is-default" onclick="location.href='{{ url(route('admin.system.pagecontent.index', [ 'page' => $page ])) }}'">返回</b-button>
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
        <form wire:submit.prevent="">

            <section>
                <div class="field">
                    <b-field label="類別" @error('page_content.type') type="is-danger"
                             message="請選擇一種類別" @enderror>
                        <b-radio wire:model="page_content.type"
                                 name="type"
                                 native-value="1">
                            圖/文章
                        </b-radio>
                        <b-radio wire:model="page_content.type"
                                 name="type"
                                 native-value="2">
                            純文章
                        </b-radio>
                        <b-radio wire:model="page_content.type"
                                 name="type"
                                 native-value="3">
                            圖片
                        </b-radio>
                    </b-field>

                    @if($this->page_content->type==1)
                        <b-field label="圖片位置" @error('page_content.pic_align') type="is-danger"
                                 message="請選擇圖片位置" @enderror>
                            <b-radio wire:model="page_content.pic_align"
                                     name="pic_align"
                                     native-value="1">
                                圖置左
                            </b-radio>
                            <b-radio wire:model="page_content.pic_align"
                                     name="pic_align"
                                     native-value="2">
                                圖置右
                            </b-radio>
                        </b-field>
                    @endif

                    <b-field label="版面主題" @error('page_content.title') type="is-danger"
                             message="請輸入版面主題" @enderror>
                        <b-input name="title" maxlength="100" wire:model="page_content.title"></b-input>
                    </b-field>

                    <div class="field is-horizontal is-grouped">

                        @if($this->page_content->type==1 || $this->page_content->type==3)
                            <b-field class="file is-primary">
                                <b-upload wire:model="page_content.pic" class="file-label">
                                <span class="file-cta">
                                    <b-icon class="file-icon" icon="upload"></b-icon>
                                    <span class="file-label">Click to upload</span>
                                </span>
                                </b-upload>
                            </b-field>
                        @endif


                    </div>
                    @if($this->page_content->type==1 || $this->page_content->type==2)
                        <textarea id="body" style="height: 375px" wire:model="page_content.body">aaaa</textarea>
                    @endif

                    <div class="buttons">
                        <b-button native-type="submit" type="is-info" label="送出" id="button"></b-button>
                    </div>
                </div>
            </section>
        </form>
    </template>
</div>

