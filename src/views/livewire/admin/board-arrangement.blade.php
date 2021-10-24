<div>
    請選擇此佈告欄是否要有左選單

    <form wire:submit.prevent="submit">
        <div>
            <select wire:model="parent_menu_id" class="m-5 p-4">
                <option value="0">--沒有左選單--</option>
                @foreach($parent_menus as $parent_menu)
                    <option value="{{ $parent_menu->id }}">{{ $parent_menu->ctitle }}</option>
                @endforeach
            </select>
        </div>

        @if($this->menus->count())
            <div class="m-5">
                內容：
                <ol>
                    @foreach($this->menus as $menu)
                        <li>{{ $menu->ctitle }}</li>
                    @endforeach
                </ol>
            </div>
        @endif


        <div>
            <button type="submit" class="button is-info">選擇這個選單</button>
        </div>


    </form>
</div>
