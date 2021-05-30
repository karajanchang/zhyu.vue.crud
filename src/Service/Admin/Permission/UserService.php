<?php
/**
 * Created by PhpStorm.
 * User: david
 * Date: 2019-03-20
 * Time: 15:02
 */

namespace ZhyuVueCurd\Service\Admin\Permission;

use App\Models\User;
use ZhyuVueCurd\Repositories\Admin\Permission\UserRepository;
use ZhyuVueCurd\Service\AbstractCrulService;
use ZhyuVueCurd\Service\TraitCrulService;


class UserService extends AbstractCrulService
{
    use TraitCrulService;

    /*
     * set repository
     *
     * @return string
     */
    public function repository()
    {
        return UserRepository::class;
    }

    private function processParams(array $params, bool $is_update = false){
//        $params['parent_id'] = !isset($params['parent_id']) ? 0 : (int) $params['parent_id'];
//        $params['orderby'] = !isset($params['orderby']) ? 1 : (int) $params['orderby'];
        return $params;
    }


    public function updateCurrentTeamId(User $user, int $current_team_id){
        $user->current_team_id = $current_team_id;

        $user->save();

        return true;
    }
}
