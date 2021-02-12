<?php
/**
 * Created by PhpStorm.
 * User: david
 * Date: 2019-03-20
 * Time: 15:02
 */

namespace ZhyuVueCurd\Repositories\Admin\System;

use ZhyuVueCurd\Models\Menu;


use Zhyu\Repositories\Eloquents\Repository;

class MenuRepository extends Repository
{

    public function model()
    {
        return Menu::class;
    }

    /*
     * 塞入預設值
     */
    public function initFirst(){
        $admin = $this->create([
            'title' => 'admin_leftmenu',
            'ctitle' => '後台左邊選單',
            'is_can_delete' => 0,
            'orderby' => 1,
        ]);

        $system = $this->create([
            'title' => 'system',
            'ctitle' => '網站設定',
            'parent_id' => $admin->id,
            'icon' => 'view-dashboard',
            'is_can_delete' => 0,
            'orderby' => 1,
        ]);

        $config = $this->create([
            'title' => 'config',
            'ctitle' => '設定',
            'url' => '/admin/system/config',
            'parent_id' => $system->id,
            'is_can_delete' => 0,
            'orderby' => 1,
        ]);

        $config = $this->create([
            'title' => 'menu',
            'ctitle' => '選單管理',
            'url' => '/admin/system/menu',
            'parent_id' => $system->id,
            'is_can_delete' => 0,
            'orderby' => 2,
        ]);

        $page = $this->create([
            'title' => 'page',
            'ctitle' => '頁面管理',
            'url' => '/admin/system/page',
            'parent_id' => $system->id,
            'is_can_delete' => 0,
            'orderby' => 3,
        ]);

    }

    public function fetchByParentId(int $parent_id){

        return $this->where('id', $parent_id)->first();

    }

    public function menusByTitle(string $title){

        return $this->where('parent_id', function($query) use($title){
            $query->select('id')
                ->where('title', $title)
                ->where('is_online', 1)
                ->from('menus');
        })->where('is_online', 1)->orderby('orderby', 'asc')->get();
    }

}
