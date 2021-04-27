<?php
/**
 * Created by PhpStorm.
 * User: david
 * Date: 2019-03-20
 * Time: 15:02
 */

namespace ZhyuVueCurd\Repositories\Admin\System;

use ZhyuVueCurd\Models\PageColumn;


use Zhyu\Repositories\Eloquents\Repository;

class PageColumnRepository extends Repository
{

    public function model()
    {
        return PageColumn::class;
    }

    public function countByPageContentId(int $page_content_id){

        return $this->where('page_content_id', $page_content_id)->count();
    }
}
