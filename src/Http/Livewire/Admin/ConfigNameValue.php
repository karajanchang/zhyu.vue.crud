<?php

namespace ZhyuVueCurd\Http\Livewire\Admin;

use App\Repositories\Admin\System\ConfigValueRepository;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class ConfigNameValue extends Component
{
    public $configs;
    public $configValues = [];
    public $counter = 3;


    public function increment(){
        $this->counter++;
    }

    public function mount(){
        $rows = app(ConfigValueRepository::class)->allByConfigId($this->configs->id);
        $collection = $rows->map(function($row){
            return [
                'id' => $row->id,
                'name' => $row->name,
                'value' => $row->value,
            ];
        });
        $this->configValues = $collection->toArray();
        $this->counter = count($this->configValues);
    }

    private function putConfigId2db(){
        $now = Carbon::now()->toDatetimeString();

        try {
            array_map(function ($rows) use ($now) {
                if (!empty($rows['name']) && !empty($rows['value'])) {
                    if (empty($rows['id'])) {
                        $datas = array_merge($rows, [
                            'config_id' => $this->configs->id,
                            'created_at' => $now,
                            'updated_at' => $now,
                        ]);
                        app(ConfigValueRepository::class)->insert($datas);
                    } else {
                        $rows['updated_at'] = $now;
                        app(ConfigValueRepository::class)->where('id', $rows['id'])->update($rows);
                    }
                }
            }, $this->configValues);

            return true;
        }catch (\Exception $e){
            Log::error(__CLASS__.'::'.__METHOD__.': ', [$e]);

            return false;
        }
    }

    public function submitConfigNameValueForm(){
        if(!is_array($this->configValues) && count($this->configValues)==0) return ;

        $res = $this->putConfigId2db();
        if($res===true){
            session()->flash('success_message', '執行成功!');

            return true;
        }
        session()->flash('fail_message', '執行失敗!');
    }


    public function render()
    {
        $view = 'livewire.admin.config-name-value';

        return view()->first(['vendor.'.$view, $view]);
    }
}
