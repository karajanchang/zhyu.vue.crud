<?php
/**
 * Created by PhpStorm.
 * User: david
 * Date: 2019-03-20
 * Time: 15:02
 */

namespace ZhyuVueCurd\Repositories\Admin\System;

use ZhyuVueCurd\Models\ConfigValue;


use Zhyu\Repositories\Eloquents\Repository;

class ConfigValueRepository extends Repository
{

    public function model()
    {
        return ConfigValue::class;
    }

    public function allByConfigId(int $config_id){

        return $this->where('config_id', $config_id)->get();
    }

}
