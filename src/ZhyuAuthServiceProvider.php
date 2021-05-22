<?php

namespace ZhyuVueCurd;

use App\Models\User;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Gate;
use Laravel\Jetstream\Jetstream;
use ZhyuVueCurd\Models\ResourceRolePermission;
use ZhyuVueCurd\Models\Role;
use ZhyuVueCurd\Policies\RolePolicy;

class ZhyuAuthServiceProvider extends \Illuminate\Foundation\Support\Providers\AuthServiceProvider
{
    private $roles;
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        Role::class => RolePolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
        $role_permissions = $this->getRolePermissions();
        foreach($role_permissions as $role_id => $permissions) {
            $act_lists = collect([]);
            $permissions->map(function ($permission) use ($act_lists) {
                $acts = json_decode($permission->acts);
                foreach ($acts as $act) {
                    $value = $permission->resource->slug . ':' . $act;
                    $act_lists->push($value);
                }
            });

            $role = $this->roles->where('id', $role_id)->first();
            if($role->is_online===false){
                continue;
            }

            Jetstream::role($role->slug, $role->name,
                $act_lists->toArray()
            )->description('');

            foreach ($act_lists as $act) {
                Gate::define($act, function (User $user) use ($act) {
                    if (isset($user->teams)) {
                        foreach ($user->teams as $team) {

                            return $user->hasTeamPermission($team, $act);
                        }
                    } else {

                        return false;
                    }
                });
            }

        }


    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [
            ZhyuAuthServiceProvider::class,
        ];
    }

    /**
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection|mixed
     */
    private function getRolePermissions()
    {
        $this->roles = Role::all();

        $key = env('ADMIN_AUTHORIZATION_CACHE_KEY', '_ZhyuAuth_::Permissions');
        if (Cache::has($key)) {

            return Cache::get($key);
        } else {

            $role_permissions = [];
            foreach($this->roles as $role) {
                $permissions = ResourceRolePermission::with('resource')->where('role_id', $role->id)->get();
                if($permissions->count() > 0) {
                    $role_permissions[$role->id] = $permissions;
                }
            }
            Cache::put($key, $role_permissions, now()->addMinutes(env('ADMIN_AUTHORIZATION_EXPIRED_MINUTES', 60)));

            return $role_permissions;
        }
    }

}
