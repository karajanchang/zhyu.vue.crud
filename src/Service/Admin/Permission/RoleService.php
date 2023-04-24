<?php
/**
 * Created by PhpStorm.
 * User: david
 * Date: 2019-03-20
 * Time: 15:02
 */

namespace ZhyuVueCurd\Service\Admin\Permission;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use ZhyuVueCurd\Models\Role;
use ZhyuVueCurd\Repositories\Admin\Permission\RoleRepository;
use ZhyuVueCurd\Repositories\Admin\Permission\ResourceRolePermissionRepository;
use ZhyuVueCurd\Service\AbstractCrulService;
use ZhyuVueCurd\Service\TraitCrulService;


class RoleService extends AbstractCrulService
{
    use TraitCrulService;

    /*
     * set repository
     *
     * @return string
     */
    public function repository()
    {
        return RoleRepository::class;
    }

    private function processParams(array $params, bool $is_update = false){
//        $params['parent_id'] = !isset($params['parent_id']) ? 0 : (int) $params['parent_id'];
//        $params['orderby'] = !isset($params['orderby']) ? 1 : (int) $params['orderby'];
        return $params;
    }

    public function permissionsByRole(Role $role){

        return app(ResourceRolePermissionRepository::class)->allByRoleId($role->id);
    }

    public function permissionsWithSlugByRole(Role $role){

        return app(ResourceRolePermissionRepository::class)->allWithSlugByRoleId($role->id);
    }

    public function permissionsSaveByRole(Role $role, array $all){
        try {
            if (count($all['resource_id']) > 0) {
                $lock = Cache::lock('permissionsSaveByRole'.$role->id, 10);

                if($lock->get()) {
                    DB::beginTransaction();
                    foreach ($all['resource_id'] as $resource_id => $acts) {
                        $act = json_encode($acts);
                        $resourceRolePermission = app(ResourceRolePermissionRepository::class)->firstByResourceIdAndRoleId($resource_id, $role->id);
                        //--更新
                        if (isset($resourceRolePermission->id)) {
                            $resourceRolePermission->acts = $act;
                            $resourceRolePermission->save();
                            //--新增
                        } else {
                            app(ResourceRolePermissionRepository::class)->create([
                                'resource_id' => $resource_id,
                                'role_id' => $role->id,
                                'acts' => $act,
                            ]);
                        }
                    }
                    DB::commit();
                    $lock->release();
                }
            }
            return true;
        }catch (\Exception $e){
            Log::error(__CLASS__.'::'.__METHOD__.': ', [$e]);
            DB::rollBack();
        }

        return false;
    }
}
