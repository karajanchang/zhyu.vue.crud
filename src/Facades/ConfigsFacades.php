<?php
namespace ZhyuVueCurd\Facades;


use Illuminate\Support\Facades\Facade;

class ConfigsFacades extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'Configs';
    }
}
