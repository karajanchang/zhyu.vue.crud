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
        $permissions = $this->getPermissions();

        $permissions->map(function($permission){
            $act_lists = json_decode($permission->acts);
            $acts = array_map(function($act) use($permission){

                return $permission->resource->slug.':'.$act;
            }, $act_lists);

            Jetstream::role($permission->role->slug, $permission->role->name,
                $acts
            )->description('');

            foreach($acts as $act) {
                Gate::define($act, function (User $user) use($act){
                    if(isset($user->teams)){
                        foreach($user->teams as $team){

                            return $user->hasTeamPermission($team, $act);
                        }
                    }else{

                        return false;
                    }
                });
            }

        });

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
    private function getPermissions()
    {
        $key = env('ADMIN_AUTHORIZATION_CACHE_KEY', '_ZhyuAuth_::Permissions');
        if (Cache::has($key)) {

            return Cache::get($key);
        } else {
            $permissions = ResourceRolePermission::with('role', 'resource')->get();
            Cache::put($key, $permissions, now()->addMinutes(env('ADMIN_AUTHORIZATION_EXPIRED_MINUTES', 60)));

            return $permissions;
        }
    }

}
