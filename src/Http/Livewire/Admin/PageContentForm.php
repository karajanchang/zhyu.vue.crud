<?php


namespace ZhyuVueCurd\Http\Livewire\Admin;


use App\Models\PageContent;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class PageContentForm extends Component
{
    public $page;
    public $page_content;

    protected $rules = [
        'page_content.type' => 'required|integer',
        'page_content.title' => 'required|string',
        'page_content.body' => 'nullable',
        'page_content.pic' => 'nullable|string',
        'page_content.pic_align' => 'nullable|integer',
    ];

    protected $listeners = ['submitPageContentForm'];

    public function setBody($body){
        dump('111111111111111111111');
        Log::info('setBody................', [$body]);
        $this->submitPageContentForm();
    }

    public function submitPageContentForm($body){
        $this->validate();
        $this->page_content->body = $body;
        dump($this->page_content);
    }

    public function mount(){
        if(is_null($this->page_content)) {
            $this->page_content = new PageContent();
            $this->page_content->type = 1;
            $this->page_content->pic_align = 1;
        }
    }

    public function render(){

        return view()->first(['ZhyuVueCurd::livewire.admin.page-content-form']);
    }

}
