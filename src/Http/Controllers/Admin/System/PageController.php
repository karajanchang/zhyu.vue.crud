<?php
namespace ZhyuVueCurd\Http\Controllers\Admin\System;


use ZhyuVueCurd\Service\Admin\System\PageService;
use ZhyuVueCurd\Http\Controllers\CRULInterface;
use ZhyuVueCurd\Http\Controllers\CRULTrait;
use ZhyuVueCurd\Http\Controllers\CrulController;

class PageController extends CrulController implements CRULInterface
{
    use CRULTrait;

    protected $module = 'admin';
    protected $tag = 'system.page';

    /*
     * Service 設定
     */
    public function service()
    {

        return PageService::class;
    }



}
