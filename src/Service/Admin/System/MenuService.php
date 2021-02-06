<?php
/**
 * Created by PhpStorm.
 * User: david
 * Date: 2019-03-20
 * Time: 15:02
 */

namespace ZhyuVueCurd\Service\Admin\System;

use ZhyuVueCurd\Repositories\Admin\System\MenuRepository;
use ZhyuVueCurd\Service\AbstractCurlService;
use ZhyuVueCurd\Service\TraitCurlService;


class MenuService extends AbstractCurlService
{
    use TraitCurlService;

    /*
     * set repository
     *
     * @return string
     */
    public function repository()
    {
        return MenuRepository::class;
    }

    private function processParams(array $params, bool $is_update = false){
        $params['parent_id'] = !isset($params['parent_id']) ? 0 : (int) $params['parent_id'];
        $params['orderby'] = !isset($params['orderby']) ? 1 : (int) $params['orderby'];
        return $params;
    }

}
