<?php

namespace ZhyuVueCurd\Http\Livewire\Admin;

use App\Repositories\Admin\System\MenuRepository;
use Livewire\Component;

class LeftMenu extends Component
{
    public function getMenus(){

        return app(MenuRepository::class)->menusByTitle('admin_leftmenu');
    }
    public function render()
    {
        $view = 'livewire.admin.left-menu';

        return view()->first([$view, 'vendor.'.$view, 'ZhyuVueCurd::'.$view], [
            'menus' => $this->getMenus(),
        ]);
    }
}
