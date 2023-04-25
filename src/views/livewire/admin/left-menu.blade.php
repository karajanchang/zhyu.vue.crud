<div>
    <div class="sidebar" id="menu">
        <b-menu>
            @php
                $userPermissonSlugs = app(\ZhyuVueCurd\Service\Admin\Permission\RoleService::class)->permissionsWithSlugByRole(auth()->user()->role)->pluck('slug')->toArray();
                $menu_active = [];
                $menu_permissions = [];
            @endphp

            @if($menus->count() > 0)
                @foreach($menus as $key => $menu)
                    @php
                        if($menu->is_online==1){
                            $children = $menu->children()->where('is_online', 1)->cursor();
//                            $children = $menu->children;
                            if($children->count() > 0){
                                foreach($children as $key2 => $child){
                                    if(in_array($child->title, $userPermissonSlugs)){
                                            $menu_permissions[$menu->id][$child->id] = 'true';
                                    }else{
                                    }
                                    if($child->is_online==1 && ifMatchUrl($child->url)){
                                        $menu_active[$key] = true;
                                        //@break
                                    }
                                }
                            }else{
                                if(in_array($menu->title, $userPermissonSlugs)){
                                    $menu_permissions[$menu->id] = 'true';
                                }
                            }
                        }
                    @endphp
                @endforeach

                @foreach($menus as $key => $menu)
                    @if($menu->is_online==1)
                        @php
                            $icon_pack = $menu->icon_pack ?? '';
                            $icon = $menu->icon ?? 'view-dashboard';
                            $children = $menu->children()->where('is_online', 1)->cursor();
                        @endphp

                        @if(isset($menu_permissions[$menu->id]))
                            @if($children->count() > 0)
                                <b-menu-list label="">
                                    <b-menu-item icon-pack="{{ $icon_pack }}" icon="{{ $icon }}" @if(isset($menu_active[$key]) && $menu_active[$key]===true) :active="true"  @endif :expanded="true" >
                                        <template slot="label" slot-scope="props">
                                            {{ $menu->ctitle }}
                                            <b-icon class="is-pulled-right" :icon="props.expanded ? 'menu-down' : 'menu-up'"></b-icon>
                                        </template>
                                        @foreach($children as $child)
                                            @if(isset($menu_permissions[$menu->id][$child->id]))
                                                @php
                                                    $icon_pack = $child->icon_pack ?? 'fas';
                                                    $icon = $child->icon ?? 'square';
                                                @endphp
                                                @if($child->is_online==1)
                                                    <b-menu-item label="{{ $child->ctitle }}" icon-pack="{{ $icon_pack }}" icon="{{ $icon }}" href="{{ $child->url }}" @if(ifMatchUrl($child->url)) active @endif></b-menu-item>
                                                @endif
                                            @else
                                                {{--                                                @ray($child, $menu_permissions, 'menu_id:'.$menu->id.', child_id:'.$child->id)--}}
                                            @endif
                                        @endforeach
                                    </b-menu-item>
                                </b-menu-list>
                            @else
                                <b-icon icon-pack="{{ $icon_pack }}" icon="{{ $icon }}" class="m-1"></b-icon><a href="{{ $menu->url }}" aria-label="{{ $menu->ctitle }}">{{ $menu->ctitle }}</a>
                            @endif
                        @endif
                    @endif
                @endforeach
            @endif
            <div id="logout">
                <b-menu-list label="Actions">
                    <b-menu-item label="登出" onclick="logout()"></b-menu-item>
                </b-menu-list>
            </div>

        </b-menu>

    </div>

    <script>
        function logout(){
            axios.post('/admin/logout')
                .then(({ data }) => {
                    this.loading = true
                    location.href='/admin/login'
                })
                .catch((error) => {
                    this.loading = false
                    console.log(error)
                    throw error
                });
        }
    </script>
</div>