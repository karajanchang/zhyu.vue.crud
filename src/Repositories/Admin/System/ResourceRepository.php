<?php


namespace ZhyuVueCurd\Repositories\Admin\System;


use Zhyu\Repositories\Eloquents\Repository;
use ZhyuVueCurd\Models\Resource;

class ResourceRepository extends Repository
{
    public function model()
    {
        return Resource::class;
    }

    public function countBySlug(string $slug){
        
        return $this->where('slug', $slug)->count();
    }
    
}
