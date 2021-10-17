<?php


namespace ZhyuVueCurd\Http\Livewire\Admin;


use Illuminate\Support\Facades\DB;
use ZhyuVueCurd\Models\PageColumn;
use ZhyuVueCurd\Models\PageContent;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class PageContentFormEdit extends Component
{
    public $page;
    public $page_content;
    public $column_sizes = [];

    protected $rules = [
        'page_content.title' => 'nullable|string',
        'page_content.subtitle' => 'nullable|string',
        'page_content.column_nums' => 'nullable|integer',
        'page_content.is_vcentered' => 'nullable|boolean',
        'page_content.is_multiline' => 'nullable|boolean',
        'page_content.is_centered' => 'nullable|boolean',
        'page_content.container' => 'nullable|boolean',
        'page_content.is_fluid' => 'nullable|boolean',
        'page_content.gap' => 'required|integer',
        'page_content.orderby' => 'required|integer',
        'column_sizes' => 'nullable',
    ];

    protected $listeners = ['submitPageContentFormEdit'];

   

    public function changeColumnNums($value){
//        $this->page_content->column_nums = $value;
//        Log::info('CCCCCCCCCCCCCCCCCCCCCCCCCCCCCCC', [$value]);
//        $this->calColumnSizes();
    }


    public function submitPageContentFormEdit(){
        $this->validate();

        try {
            DB::beginTransaction();

            $this->page_content->save();


            DB::commit();
            $this->redirect(route('admin.system.pagecontent.index', [ 'page' => $this->page ]));
        }catch (\Exception $e){
            DB::rollBack();
            throw $e;
        }
    }

    public function mount(){
    }


    public function render(){

        return view()->first(['ZhyuVueCurd::livewire.admin.page-content-form-edit']);
    }

}
