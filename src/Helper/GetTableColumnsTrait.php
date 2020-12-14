<?php


namespace ZhyuVueCurd\Helper;


use Illuminate\Support\Facades\DB;

trait GetTableColumnsTrait
{
    protected function getTableColumns($table){

        return DB::getSchemaBuilder()->getColumnListing($table);
    }
}
