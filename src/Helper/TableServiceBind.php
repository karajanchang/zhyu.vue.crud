<?php


namespace ZhyuVueCurd\Helper;



use ZhyuVueCurd\Service\Table\TableService;

class TableServiceBind
{
    public static function bind(string $tag){

        return app(TableService::class, ['tag' => $tag]);
    }
}