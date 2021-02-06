<?php

namespace ZhyuVueCurd\Http\Livewire\Admin;

use ZhyuVueCurd\Repositories\Admin\System\MenuRepository;
use Livewire\Component;

class MenuBreadcrumb extends Component
{
    public $parent_id;
    public $parents = [];


    private function getParent(int $parent_id = null){
        if(!is_null($parent_id) && $parent_id > 0) {
            $menu = app(MenuRepository::class)->fetchByParentId($parent_id);
            array_push($this->parents, $menu);
            $this->getParent($menu->parent_id);
        }
        //krsort($this->parents);
    }


    public function render()
    {
        $this->getParent($this->parent_id);
        $view = 'livewire.admin.menu-breadcrumb';

        return view()->first([$view, 'vendor.'.$view, 'ZhyuVueCurd::'.$view], [
            'parents' => $this->parents
        ]);
    }

}
