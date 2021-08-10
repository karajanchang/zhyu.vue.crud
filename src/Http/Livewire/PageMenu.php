<?php


namespace ZhyuVueCurd\Http\Livewire;


use Livewire\Component;
use ZhyuVueCurd\Repositories\Admin\System\MenuRepository;

class PageMenu extends Component
{
    public $page;
    public $menus;

    protected $rules = [
    ];

    protected $listeners = [];

    public function mount(){
        if(isset($this->page->menu_id)) {
            $this->menus = app(MenuRepository::class)->menusSameLevelByMenuId($this->page->menu_id);
        }
    }


    public function render(){

        return view()->first(['ZhyuVueCurd::livewire.page.menu']);
    }

}
