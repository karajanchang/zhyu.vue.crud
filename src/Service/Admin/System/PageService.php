<?php
/**
 * Created by PhpStorm.
 * User: david
 * Date: 2019-03-20
 * Time: 15:02
 */

namespace ZhyuVueCurd\Service\Admin\System;

use ZhyuVueCurd\Repositories\Admin\System\PageRepository;
use ZhyuVueCurd\Service\AbstractCrulService;
use ZhyuVueCurd\Service\TraitCrulService;


class PageService extends AbstractCrulService
{
    use TraitCrulService;

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
