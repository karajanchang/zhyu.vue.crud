<?php

namespace ZhyuVueCurd\Policies;

use App\Models\Team;
use App\Models\User;
use ZhyuVueCurd\Models\Role;
use Illuminate\Auth\Access\HandlesAuthorization;

class RolePolicy
{
    use HandlesAuthorization;

    private $superAdminTeam;

    public function __construct(){
        $this->superAdminTeam = Team::find(1);
    }
    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->hasTeamPermission($this->superAdminTeam, 'role:read');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \ZhyuVueCurd\Models\Role  $role
     * @return mixed
     */
    public function view(User $user, Role $role)
    {
        return $user->hasTeamPermission($this->superAdminTeam, 'role:read');
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasTeamPermission($this->superAdminTeam, 'role:create');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \ZhyuVueCurd\Models\Role  $role
     * @return mixed
     */
    public function update(User $user, Role $role)
    {
        return $user->hasTeamPermission($this->superAdminTeam, 'role:update') && !in_array($role->role, ['super_admin', 'admin']);
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \ZhyuVueCurd\Models\Role  $role
     * @return mixed
     */
    public function delete(User $user, Role $role)
    {
        return $user->hasTeamPermission($this->superAdminTeam, 'role:delete') && !in_array($role->role, ['super_admin', 'admin']);
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \ZhyuVueCurd\Models\Role  $role
     * @return mixed
     */
    public function restore(User $user, Role $role)
    {
        return $user->hasTeamPermission($this->superAdminTeam, 'role:delete');
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \ZhyuVueCurd\Models\Role  $role
     * @return mixed
     */
    public function forceDelete(User $user, Role $role)
    {
        return $user->hasTeamPermission($this->superAdminTeam, 'role:delete');
    }
}
