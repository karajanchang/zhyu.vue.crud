<?php


namespace ZhyuVueCurd\Helper;


use Illuminate\Support\Facades\Cache;
use ZhyuVueCurd\Repositories\ConfigRepostitory;

class ConfigsHelper
{
    private $repository;

    /*
     * string $tag  標籤
     * integer $timeout  幾分鐘後過期
     */
    public function get(string $tag, int $timeout = null){
        $key = 'ZhyuVueCurdConfigs-'.$tag;
        if(!Cache::has($key)) {
            $config = app(ConfigRepostitory::class)->firstByTag($tag);
            if(is_null($config)){

                return null;
            }
            Cache::put($key, $config->value, now()->addMinutes($timeout ?? 5));

            return $config->value;
        }

        return Cache::get($key);
    }

}
