<?php
/**
 * Created by PhpStorm.
 * User: david
 * Date: 2019-03-20
 * Time: 15:02
 */

namespace ZhyuVueCurd\Repositories\Admin\Permission;



use Zhyu\Repositories\Eloquents\Repository;
use ZhyuVueCurd\Models\TeamUser;

class TeamUserRepository extends Repository
{

    public function model()
    {
        return TeamUser::class;
    }

}
