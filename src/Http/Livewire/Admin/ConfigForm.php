<?php

namespace ZhyuVueCurd\Http\Livewire\Admin;

use App\Models\Config;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use Livewire\Component;

class ConfigForm extends Component
{
    public $configs;

    protected $rules = [
        'configs.tag' => 'required|string|unique:configs,tag',
        'configs.ctitle' => 'required|string',
        'configs.type' => 'required|integer',
    ];

    /*
    public function updated($propertyName)
    {
        Log::info('ConfigForm.......................', [$propertyName]);
        $this->validateOnly($propertyName);
    }
    */

    public function mount(){
        if(is_null($this->configs)) {
            $this->configs = new Config();
            $this->configs->type = 1;
        }
    }

    public function submitConfigForm(){
        Log::info('ConfigForm.......................', [
            $this->configs,
        ]);

        if(isset($this->configs->id)) {
            $unique = Rule::unique('configs', 'tag')->ignore($this->configs->id);
            $this->rules['configs.tag'] = 'required|string|'.$unique;
        }

        $data = $this->validate();

        //---save
        if(!isset($this->configs->id)) {
            Config::create($data['configs']);
        }else{
            $this->configs->save();
        }

        redirect()->route('admin.system.config.index');
    }

    public function render()
    {
        $view = 'livewire.admin.config-form';

        return view()->first([$view, 'vendor.'.$view, 'ZhyuVueCurd::'.$view]);
    }
}
