<?php


namespace ZhyuVueCurd\Http\Livewire\Admin;


use Livewire\Component;
use ZhyuVueCurd\Models\Menu;

class PageArrangement extends Component
{
    public $parent_menu_id = 0;
    public $menu_id = 0;
    public $menu_id2 = 0;
    private $is_have_child = true;
    public $page;


    public function updatedParentMenuId($value){
//        $this->menus($value);
    }

    public function submit(){
        $this->page->left_menu_id = $this->parent_menu_id==0 ? null : $this->parent_menu_id;
        $this->page->save();

        return redirect()->to(
            route('admin.system.page.index')
        );
    }


    public function getMenusProperty(){
        if($this->parent_menu_id==0){

            return collect([]);
        }
        $rows = Menu::where('parent_id', $this->parent_menu_id)->get();
        $this->isHaveChild($rows);

        return $rows;
    }
    public function getMenus2Property(){
        if($this->menu_id==0){

            return collect([]);
        }
        $rows = Menu::where('parent_id', $this->menu_id)->get();
        $this->isHaveChild($rows);

        return $rows;
    }

    private function isHaveChild($rows){
        if($rows->count()==0){
            $this->is_have_child = false;
        }
    }


    public function mount(){
        $this->parent_menu_id = (int) $this->page->left_menu_id;
    }

    public function render(){
        $parent_menus = Menu::where('parent_id', 0)->where('id', '>', 3)->get();

        return view()->first(['ZhyuVueCurd::livewire.admin.page-arrangement'], compact('parent_menus'));
    }
}
