<?php
namespace ZhyuVueCurd\Repositories;


use Zhyu\Repositories\Eloquents\Repository;
use ZhyuVueCurd\Models\Config;

class ConfigRepostitory extends Repository
{
    public function model()
    {
        return Config::class;
    }

    public function firstByTag(string $tag){

        return $this->where('tag', $tag)->select('value')->first();
    }
}
