<div class="sidebar" id="menu">
    <b-menu>
        @php
            $menu_active = [];
        @endphp
        @if($menus->count() > 0)
            @foreach($menus as $key => $menu)
                @php
                    $children = $menu->children;
                    $menu_active[$key] = false;
                @endphp
                @if($children->count() > 0)
                    @foreach($children as $child)
                        @if(ifMatchUrl($child->url))
                            @php
                                $menu_active[$key] = true;
                            @endphp
                            @break
                        @endif
                    @endforeach
                @endif
            @endforeach

            @foreach($menus as $key => $menu)
                @php
                    $icon_pack = $menu->icon_pack ?? '';
                    $icon = $menu->icon ?? 'view-dashboard';
                    $children = $menu->children;
                @endphp
                @if($children->count() > 0)
                    <b-menu-list label="">
                        <b-menu-item icon-pack="{{ $icon_pack }}" icon="{{ $icon }}" @if(isset($menu_active[$key]) && $menu_active[$key]===true) :active="true"  @endif :expanded="true" >
                            <template slot="label" slot-scope="props">
                                {{ $menu->ctitle }}
                                <b-icon class="is-pulled-right" :icon="props.expanded ? 'menu-down' : 'menu-up'"></b-icon>
                            </template>
                            @foreach($children as $child)
                                @php
                                    $icon_pack = $child->icon_pack ?? 'fas';
                                    $icon = $child->icon ?? 'square';
                                @endphp
                                <b-menu-item label="{{ $child->ctitle }}" icon-pack="{{ $icon_pack }}" icon="{{ $icon }}" href="{{ $child->url }}" @if(ifMatchUrl($child->url)) active @endif></b-menu-item>
                            @endforeach
                        </b-menu-item>
                    </b-menu-list>
                @else
                    <b-icon icon-pack="{{ $icon_pack }}" icon="{{ $icon }}" class="m-1"></b-icon><a href="{{ $menu->url }}" aria-label="{{ $menu->ctitle }}">{{ $menu->ctitle }}</a>
                @endif
            @endforeach
        @endif
        <div id="logout">
            <b-menu-list label="Actions">
                <b-menu-item label="登出" @click="logout"></b-menu-item>
            </b-menu-list>
        </div>

    </b-menu>

</div>
<script>
    function logout(){
        axios.post('/admin/logout');
    }
</script>
