<?php


namespace ZhyuVueCurd\Http\Livewire\Admin;


use Illuminate\Support\Facades\DB;
use ZhyuVueCurd\Models\PageColumn;
use ZhyuVueCurd\Models\PageContent;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class PageContentForm extends Component
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
        'column_sizes' => 'required|array',
    ];

    protected $listeners = ['submitPageContentForm'];

    /*
    public function setBody($body){
        dump('111111111111111111111');
        Log::info('setBody................', [$body]);
        $this->submitPageContentForm();
    }
    */

    public function changeColumnNums($value){
        $this->page_content->column_nums = $value;
        Log::info('CCCCCCCCCCCCCCCCCCCCCCCCCCCCCCC', [$value]);
        $this->calColumnSizes();
    }


    public function submitPageContentForm(){
        $this->validate();

        try {
            DB::beginTransaction();
            $this->page_content->page()->associate($this->page);
            $this->page_content->save();
            $columns = [];
            foreach($this->column_sizes as $column_size){
                $page_column = new PageColumn();
                $page_column->size = $column_size;
                array_push($columns, $page_column);
            }
            $this->page_content->columns()->saveMany($columns);

            DB::commit();
            $this->redirect(route('admin.system.pagecontent.index', [ 'page' => $this->page ]));
        }catch (\Exception $e){
            DB::rollBack();
            throw $e;
        }
    }

    public function mount(){
        if(is_null($this->page_content)) {
            $this->page_content = new PageContent();
            $this->page_content->column_nums = 2;
            $this->page_content->is_vcentered = false;
            $this->page_content->is_multiline = false;
            $this->page_content->is_centered = false;
            $this->page_content->container = false;
            $this->page_content->is_fluid = false;
            $this->page_content->gap = 3;
            $this->page_content->orderby = ($this->page->contents->count()+1) ?? 1;
        }
        $this->calColumnSizes();
    }

    public function calColumnSizes(){
        $each_size = round(12 / $this->page_content->column_nums);
        $this->column_sizes = [];
        for($i=0; $i < $this->page_content->column_nums; $i++){
            $this->column_sizes[$i] = $each_size;
        }
    }

    public function render(){

        return view()->first(['ZhyuVueCurd::livewire.admin.page-content-form']);
    }

}
