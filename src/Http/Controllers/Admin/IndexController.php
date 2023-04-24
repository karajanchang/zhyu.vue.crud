<?php


namespace ZhyuVueCurd\Http\Controllers\Admin;


use ZhyuVueCurd\Http\Controllers\Controller;
use ZhyuVueCurd\Repositories\Admin\System\MenuRepository;

class IndexController extends Controller
{
    public function index(){
        if(!auth()->check()){
            return redirect('/admin/login');
        }

        $redirect_url = $this->getFirstUrl();
        return redirect()->to($redirect_url);

//        return view()->first([
//            'vendor.admin.index',
//            'vendor.admin.home',
//            'vendor.admin.dashboard',
//            'vendor.admin.welcome',
//            'ZhyuVueCurd::admin.index',
//        ]);
    }

    private function getFirstUrl(){
        $permission = auth()->user()->role->permissions->first();
        $slug = $permission->resource->slug;

        $url = '/admin';
        $menus = app(MenuRepository::class)->menusByTitle('admin_leftmenu');
        foreach($menus as $menu){
            $children = $menu->children;
            if($children->count()) {
                foreach ($children as $child) {
                    if($child->title=== $slug){
                        return $child->url;
                    }
                }
            }else{
                if($menu->title=== $slug){
                    return $menu->url;
                }
            }
        }
    }
}
