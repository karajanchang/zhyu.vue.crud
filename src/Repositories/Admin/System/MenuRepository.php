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


    /**
     * 從 menu_id 去看同層有哪些menus
     * @param int $menu_id
     * @return mixed
     */
    public function menusSameLevelByMenuId(int $menu_id){
        $menus = $this->where('parent_id', function($query) use($menu_id){
            $query->from('menus')->where('id', $menu_id)->select('parent_id');
        })
            ->where('is_online', 1)
            ->get();

        return $menus;
    }

    /**
     * 從title去拿到上線的選單
     * @param string $title
     * @return mixed
     */
    public function menusByTitle(string $title){

        return $this->where('parent_id', function($query) use($title){
            $query->select('id')
                ->where('title', $title)
                ->where('is_online', 1)
                ->from('menus');
        })->where('is_online', 1)->orderby('orderby', 'asc')->get();
    }

    /**
     * 從 parent_id 去得到它下層的選單
     * @param int $parent_id
     * @return mixed
     */
    public function menusByParentId(int $parent_id){

        return $this->where('parent_id', $parent_id)->orderby('id', 'asc')->get();
    }

    /**
     * 遞迴去拿到所有最後的node
     * @param int $menu_id
     * @param array $lastNodes
     * @return array
     */
    public function menusLastNodeById(int $menu_id, array $lastNodes = []){
        $rows = $this->menusByParentId($menu_id);
        if($rows->count() > 0){
            foreach($rows as $row){
                $count = $this->where('parent_id', $row->id)->count();
                if($count == 0){
                    array_push($lastNodes, $row);
                }else{
                    $lastNodes = $this->menusLastNodeById($row->id, $lastNodes);
                }
            }

            return $lastNodes;
        }
    }
}
