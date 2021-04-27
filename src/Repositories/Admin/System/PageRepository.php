<?php
/**
 * Created by PhpStorm.
 * User: david
 * Date: 2019-03-20
 * Time: 15:02
 */

namespace ZhyuVueCurd\Repositories\Admin\System;

use ZhyuVueCurd\Models\Page;


use Zhyu\Repositories\Eloquents\Repository;

class PageRepository extends Repository
{

    public function model()
    {
        return Page::class;
    }

    public function findByUri(string $uri){

        return $this->where('uri', $uri)->first();
    }
}
