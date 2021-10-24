<?php
/**
 * Created by PhpStorm.
 * User: david
 * Date: 2019-03-20
 * Time: 15:02
 */

namespace ZhyuVueCurd\Repositories\Admin\Announcement;

use ZhyuVueCurd\Models\Board;


use Zhyu\Repositories\Eloquents\Repository;

class BoardRepository extends Repository
{

    public function model()
    {
        return Board::class;
    }

}
