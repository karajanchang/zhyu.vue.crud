<?php


namespace ZhyuVueCurd\Commands;


use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use ZhyuVueCurd\Models\Resource;
use ZhyuVueCurd\Models\Role;
use ZhyuVueCurd\Repositories\Admin\System\MenuRepository;
use ZhyuVueCurd\Repositories\Admin\System\ResourceRepository;
use ZhyuVueCurd\Repositories\Admin\System\ResourceRolePermissionRepository;

class AdminInitalCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'admin:inital {role}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '初始化管理者環境的資源和權限 admin:inital super_admin';


    public function handle()
    {
        $slug = $this->argument('role');
        $role = Role::where('slug', $slug)->first();
        if(!isset($role->id)){
            $this->alert('該角色不存在!!!!');
            exit;
        }

        //---後台的menu id 為 3
        $rows = $this->getAllResources(3);
        foreach($rows as $row){
            $count = app(ResourceRepository::class)->countBySlug($row->title);
            if($count == 0){
                app(ResourceRepository::class)->create([
                    'slug' => $row->title,
                    'name' => $row->ctitle,
                ]);
            }
        }

        $resources = Resource::all();
        $repository = app(ResourceRolePermissionRepository::class);
        foreach($resources as $resource){
            $count = $repository->countByResourceIdAndRoleId($resource->id, $role->id);
            if($count == 0) {
                $repository->create([
                    'resource_id' => $resource->id,
                    'role_id' => $role->id,
                    'acts' => json_encode(['create', 'read', 'update', 'delete']),
                ]);
            }
        }
        
        //--清除cache
        Artisan::call('admin:cleanCache', ['--force' => true]);
    }

    /**
     * 取得 $menu_id 下所有的 lastNode
     * @param int $menu_id
     */
    private function getAllResources(int $menu_id){

        return app(MenuRepository::class)->menusLastNodeById($menu_id);
    }

}
