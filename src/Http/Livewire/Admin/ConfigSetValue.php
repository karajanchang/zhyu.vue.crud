<?php

namespace ZhyuVueCurd\Http\Livewire\Admin;

use App\Repositories\Admin\System\ConfigValueRepository;
use Illuminate\Support\Facades\Log;
use Livewire\Component;
use Livewire\WithFileUploads;

class ConfigSetValue extends Component
{
    use WithFileUploads;

    public $configs;
    public $configValues;
    public $value;
    public $is_uploaded = false;


    public function increment(){
        $this->counter++;
    }

    public function mount(){
        $rows = app(ConfigValueRepository::class)->allByConfigId($this->configs->id);

        $this->value = $this->configs->value;

        $this->configValues = $rows->map(function($row){
            return [
                'id' => $row->id,
                'name' => $row->name,
                'value' => $row->value,
            ];
        });
    }

    private function putConfigId2db(){
        try {
            //--file
            if($this->configs->type==2) {
                $this->validate([
                    'value' => 'max:2048', // 2MB Max
                ]);
                $path = $this->value->store('public/configs');
                $this->is_uploaded = true;
                Log::info('path............', [$path]);

                $this->configs->update(['value' => str_replace('public', '', $path)]);

                //--url
            }elseif($this->configs->type==7){
                $this->validate([
                    'value' => 'url', // 1MB Max
                ]);
                $this->configs->update(['value' => $this->value]);
            }else {
                $this->configs->update(['value' => $this->value]);
            }

            return true;
        }catch (\Exception $e){
            Log::error(__CLASS__.'::'.__METHOD__.': ', [$e]);

            return false;
        }
    }

    public function submitConfigSetValueForm(){
        $res = $this->putConfigId2db();
        if($res===true){
            session()->flash('success_message', '執行成功!');

            //return redirect(url(route('admin.system.config.index')));
            return ;
        }
        session()->flash('fail_message', '執行失敗!');
    }


    public function render()
    {
        $view = 'livewire.admin.config-set-value';

        return view()->first([$view, 'vendor.'.$view, 'ZhyuVueCurd::'.$view]);
    }
}
