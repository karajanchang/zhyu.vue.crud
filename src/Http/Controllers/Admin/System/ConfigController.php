<?php


namespace ZhyuVueCurd\Http\Controllers\Admin\System;


use App\Http\Controllers\Controller;
use ZhyuVueCurd\Models\Config;
use Illuminate\Support\Facades\Cache;

class ConfigController extends Controller
{
    public function index(){
        $title = '設定列表';

        return view('ZhyuVueCurd::admin.system.config.index', [
            'title' => $title,
        ]);
    }

    public function create(){
        $title = '新增設定';

        return view('ZhyuVueCurd::admin.system.config.create', [
            'title' => $title,
            'configs' => null,
        ]);
    }

    private function getConfigById(int $id){

        return Config::findOrFail($id);
    }

    public function edit(int $id){
        $title = '修改設定';
        $config = $this->getConfigById($id);

        return view('ZhyuVueCurd::admin.system.config.create', [
            'title' => $title,
            'configs' => $config,
        ]);
    }

    public function namevalue(int $id){
        $title = '設定 - 屬性設定';
        $config = $this->getConfigById($id);

        return view('ZhyuVueCurd::admin.system.config.namevalue', [
            'title' => $title,
            'configs' => $config,
        ]);
    }

    public function setvalue(int $id){
        $title = '設定 - 設定值';
        $config = $this->getConfigById($id);

        $this->clearCache($config->tag);

        return view('ZhyuVueCurd::admin.system.config.setvalue', [
            'title' => $title,
            'configs' => $config,
        ]);
    }

    private function clearCache($tag){
        $key = 'ZhyuVueCurdConfigs-'.$tag;

        return Cache::forget($key);
    }
}
