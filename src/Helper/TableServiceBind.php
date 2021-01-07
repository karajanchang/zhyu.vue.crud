<?php


namespace ZhyuVueCurd\Helper;



use ZhyuVueCurd\Service\Table\TableService;

class TableServiceBind
{
    public static function bind(string $module, string $tag){

        return app(TableService::class, ['module' => strtolower($module), 'tag' => strtolower($tag)]);
    }
}
