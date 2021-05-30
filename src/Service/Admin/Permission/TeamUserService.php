<?php
/**
 * Created by PhpStorm.
 * User: david
 * Date: 2019-03-20
 * Time: 15:02
 */

namespace ZhyuVueCurd\Service\Admin\Permission;

use App\Models\User;
use Illuminate\Support\Facades\Log;
use ZhyuVueCurd\Models\Role;
use ZhyuVueCurd\Repositories\Admin\Permission\TeamUserRepository;
use ZhyuVueCurd\Service\AbstractCrulService;
use ZhyuVueCurd\Service\TraitCrulService;


class TeamUserService extends AbstractCrulService
{
    use TraitCrulService;

    /*
     * set repository
     *
     * @return string
     */
    public function repository()
    {
        return TeamUserRepository::class;
    }

    private function processParams(array $params, bool $is_update = false){
//        $params['parent_id'] = !isset($params['parent_id']) ? 0 : (int) $params['parent_id'];
//        $params['orderby'] = !isset($params['orderby']) ? 1 : (int) $params['orderby'];
        return $params;
    }

    /**
     * @param User $user
     * @param int $role_id
     * @return mixed
     */
    public function roleSave(User $user, int $role_id){
        try {
            $teamUser = $this->firstByUser($user);

            $params = $this->generateParamsByUserAndRoleId($user, $role_id);
            if (is_null($teamUser)) {
                $teamUser = $this->insertByParams($params);
            } else {
                $teamUser->team_id = $params['team_id'];
                $teamUser->role = $params['role'];
                $teamUser->save();
            }

            return $teamUser;
        }catch (\Exception $e){
            Log::error(__CLASS__.'::'.__METHOD__, [$e]);
        }

        return false;
    }

    /**
     * @param int $role_id
     * @return mixed
     */
    private function generateParamsByUserAndRoleId(User $user, int $role_id){
        $role = Role::find($role_id);
        //--admin
        $team_id = 2;

        //--super_admin
        if($role->slug=='super_admin'){
            $team_id = 1;
        }

        return [
            'team_id' => $team_id,
            'user_id' => $user->id,
            'role' => $role->slug,
        ];
    }

    /**
     * @param array $params
     */
    private function insertByParams(array $params){
        $this->repository->create($params);
    }

    /**
     * @param User $user
     * @return mixed
     */
    public function firstByUser(User $user){

        return $this->repository->where('user_id', $user->id)->first();
    }


}
