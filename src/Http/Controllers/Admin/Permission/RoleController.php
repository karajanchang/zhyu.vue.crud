<?php
namespace ZhyuVueCurd\Http\Controllers\Admin\Permission;


use ZhyuVueCurd\Http\Requests\RolePermissionSaveRequest;
use ZhyuVueCurd\Models\Resource;
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
        $resources = Resource::all();

        $permissions = $this->service->permissionsByRole($role);

        return view('ZhyuVueCurd::admin.permission.role.permission-set', [
            'role' => $role,
            'resources' => $resources,
            'permissions' => $permissions,
        ]);
    }

    public function permissionSave(Role $role, RolePermissionSaveRequest $request){
        $all = $request->all();
        $res = $this->service->permissionsSaveByRole($role, $all);

        if($res===true){

            return redirect()->route('admin.permission.role.index');
        }


        return back()->withErrors(['msg' => '操作發生錯誤，請稍後再試']);
    }
}
