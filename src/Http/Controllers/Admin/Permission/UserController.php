<?php
namespace ZhyuVueCurd\Http\Controllers\Admin\Permission;


use App\Models\Team;
use App\Models\User;
use Illuminate\Support\Facades\Cache;
use ZhyuVueCurd\Http\Requests\RoleSaveRequest;
use ZhyuVueCurd\Models\Role;
use ZhyuVueCurd\Service\Admin\Permission\TeamUserService;
use ZhyuVueCurd\Service\Admin\Permission\UserService;
use ZhyuVueCurd\Http\Controllers\CRULInterface;
use ZhyuVueCurd\Http\Controllers\CRULTrait;
use ZhyuVueCurd\Http\Controllers\CrulController;

class UserController extends CrulController implements CRULInterface
{
    use CRULTrait;

    protected $module = 'admin';
    protected $tag = 'permission.user';

    /*
     * Service 設定
     */
    public function service()
    {

        return UserService::class;
    }


    /**
     * @param User $user
     */
    public function roleSet(User $user)
    {
        $roles = Role::all();
//        $teams = Team::all();
        //dd($user->allTeams(), $user->currentTeam);
        $teamRole = $this->getFirstTeamAndRoleFromUser($user);

        return view('ZhyuVueCurd::admin.permission.user.role-set', [
            'user' => $user,
            'roles' => $roles,
            'teamRole' => $teamRole,
        ]);
    }

    private function getFirstTeamAndRoleFromUser($user){
        $allTeams = $user->allTeams();
        if($allTeams->count() == 0){

            return [
                null,
            ];
        }
        $team = $user->allTeams()->first();
        $role = $user->teamRole($team);

        return $role->key;
    }

    /**
     * @param User $user
     */
    public function roleSave(User $user, RoleSaveRequest $request){
        $all = $request->all();

        $lock = Cache::lock('LockRoeSave'.$user->id, 10);

        if($lock->get()) {
            $teamUserService = app(TeamUserService::class);
            $teamUser = $teamUserService->roleSave($user, $all['role_id']);

            $this->service->updateCurrentTeamId($user, $teamUser->team_id);

            $lock->release();

            return redirect()->route('admin.permission.user.index');
        }

        return back()->withErrors(['msg' => '操作發生錯誤，請稍後再試']);
    }

}
