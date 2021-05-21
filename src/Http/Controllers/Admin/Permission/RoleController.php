<?php
namespace ZhyuVueCurd\Http\Controllers\Admin\Permission;


use ZhyuVueCurd\Models\Role;
use ZhyuVueCurd\Service\Admin\Permission\RoleService;
use ZhyuVueCurd\Http\Controllers\CRULInterface;
use ZhyuVueCurd\Http\Controllers\CRULTrait;
use ZhyuVueCurd\Http\Controllers\CrulController;

class RoleController extends CrulController implements CRULInterface
{
    use CRULTrait;

    protected $module = 'admin';
    protected $tag = 'permission.role';

    /*
     * Service 設定
     */
    public function service()
    {

        return RoleService::class;
    }


    public function permissionSet(Role $role){

    }

    public function permissionSave(Role $role){

    }
}
