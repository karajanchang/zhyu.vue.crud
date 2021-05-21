<?php
/**
 * Created by PhpStorm.
 * User: david
 * Date: 2019-03-20
 * Time: 15:02
 */

namespace ZhyuVueCurd\Repositories\Admin\Permission;

use ZhyuVueCurd\Models\Resource;


use Zhyu\Repositories\Eloquents\Repository;

class ResourceRepository extends Repository
{

    public function model()
    {
        return Resource::class;
    }

    public function findByUri(string $uri){

        return $this->where('uri', $uri)->first();
    }
}
