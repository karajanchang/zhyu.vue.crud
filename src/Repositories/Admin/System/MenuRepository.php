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
