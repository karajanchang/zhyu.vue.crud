<?php
/**
 * Created by PhpStorm.
 * User: david
 * Date: 2019-03-20
 * Time: 15:02
 */

namespace ZhyuVueCurd\Repositories\Admin\Permission;

use App\Models\User;


use Zhyu\Repositories\Eloquents\Repository;

class UserRepository extends Repository
{

    public function model()
    {
        return User::class;
    }

}
