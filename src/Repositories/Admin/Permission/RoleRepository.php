<?php
/**
 * Created by PhpStorm.
 * User: david
 * Date: 2019-03-20
 * Time: 15:02
 */

namespace ZhyuVueCurd\Repositories\Admin\Permission;

use ZhyuVueCurd\Models\Role;


use Zhyu\Repositories\Eloquents\Repository;

class RoleRepository extends Repository
{

    public function model()
    {
        return Role::class;
    }

    public function findByUri(string $uri){

        return $this->where('uri', $uri)->first();
    }
}
