<?php


namespace ZhyuVueCurd\Service\Table\Column;


use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Cache;

class ColumnApp
{
    private $lut = null;

    public function bind($name, bool $clearCache = false){
        $this->lut = $this->cacheLut($clearCache);
        $className = $this->lut->get($name, Input::class);

        App::bind(InterfaceColumn::class, $className);
    }

    private function getLutConfig() : string{
        $lut_file = base_path('config/lut_columns.php');
        if(file_exists($lut_file)){

            return $lut_file;
        }

        $lut_file = __DIR__.'/lut_columns.php';

        return $lut_file;
    }

    private function cacheLut(bool $clearCache = false){
        $lut_file = $this->getLutConfig();
        $key = md5($lut_file);
        if($clearCache===true){
            Cache::forget($key);
        }

        if(Cache::has($key)){

            return Cache::get($key);
        }

        if(!file_exists($lut_file))  throw new \Exception('ColumnApp lut file does not exists!!! :'.$lut_file);

        $luts = include $lut_file;
        $content = Collection::make($luts);

        $now = Carbon::now();
        Cache::put($key, $content, $now->addDays(1));

        return $content;
    }
}
