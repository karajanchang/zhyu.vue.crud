<?php
namespace ZhyuVueCurd\Http\Controllers\Admin\Permission;


use ZhyuVueCurd\Service\Admin\Permission\ResourceService;
use ZhyuVueCurd\Http\Controllers\CRULInterface;
use ZhyuVueCurd\Http\Controllers\CRULTrait;
use ZhyuVueCurd\Http\Controllers\CrulController;

class ResourceController extends CrulController implements CRULInterface
{
    use CRULTrait;

    protected $module = 'admin';
    protected $tag = 'permission.resource';

    /*
     * Service 設定
     */
    public function service()
    {

        return ResourceService::class;
    }



}
