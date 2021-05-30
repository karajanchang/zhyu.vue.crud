<?php


namespace ZhyuVueCurd\Repositories\Admin\Permission;


use Zhyu\Repositories\Eloquents\Repository;
use ZhyuVueCurd\Models\ResourceRolePermission;

class ResourceRolePermissionRepository extends Repository
{
    public function model()
    {
        return ResourceRolePermission::class;
    }

    public function countByResourceIdAndRoleId($resource_id, $role_id){

        return $this->where('resource_id', $resource_id)->where('role_id', $role_id)->count();
    }

    public function firstByResourceIdAndRoleId($resource_id, $role_id){

        return $this->where('resource_id', $resource_id)->where('role_id', $role_id)->first();
    }

    public function allByRoleId(int $role_id){

        return $this->where('role_id', $role_id)->get();
    }
}
