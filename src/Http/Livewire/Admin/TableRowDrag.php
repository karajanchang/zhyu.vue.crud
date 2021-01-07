<?php

namespace ZhyuVueCurd\Http\Livewire\Admin;

use App\Models\Menu;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class TableRowDrag extends Component
{
    public $model = null;
    public $parent_id = null;
    protected $listeners = ['draggIt'];
    private $rows;

    public function draggIt($source, $dest, $sourceId, $destId){
        $this->getRows($source);
//        dump($source, $dest, $sourceId, $destId);
        $orderby = 1;
        if($this->rows->count() > 0) {
            foreach ($this->rows as $row) {
                if($orderby==$sourceId){
                    $row->orderby = $destId;
                }else {
                    if ($orderby>=$destId){
                        $row->orderby = $orderby+1;
                    }else{
                        $row->orderby = $orderby;
                    }
                }
                $row->save();
                $orderby++;
            }
        }
        Log::info('Draggggggggggggggggggggggggggggg', [$source, $dest]);

        return $this->redirectUrl();
    }



    private function getRows($source){
        $qb = $this->model->orderby('orderby', 'asc')->select('id', 'orderby');
        if($this->model instanceof Menu) {
            $qb->where('parent_id', $source['parent_id']);
        }
        $this->rows = $qb->get();
    }

    public function redirectUrl(){
        if($this->model instanceof Menu) {

            return redirect('/admin/system/menu?parent_id='.(int) $this->parent_id);
        }
    }

    public function render()
    {
        $view = 'livewire.admin.table-row-drag';

        return view()->first(['vendor.'.$view, $view]);
    }
}
