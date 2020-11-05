<?php


namespace ZhyuVueCurd\Http\Controllers;


interface CRULInterface
{
    public function createUrl() : string;
    public function dataUrl() : string;
    public function indexUrl() : string;
    public function storeUrl() : string;

    /*
     * Service 設定
     */
    public function service();
}