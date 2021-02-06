<?php
/**
 * Created by PhpStorm.
 * User: david
 * Date: 2019-03-20
 * Time: 15:02
 */

namespace ZhyuVueCurd\Service\Admin\System;

use ZhyuVueCurd\Repositories\Admin\System\PageRepository;
use ZhyuVueCurd\Service\AbstractCurlService;
use ZhyuVueCurd\Service\TraitCurlService;


class PageService extends AbstractCurlService
{
    use TraitCurlService;

    /*
     * set repository
     *
     * @return string
     */
    public function repository()
    {
        return PageRepository::class;
    }

    private function processParams(array $params, bool $is_update = false){
        return $params;
    }

}
