<?php
namespace ZhyuVueCurd\Http\Controllers\Admin\System;


use ZhyuVueCurd\Models\Menu;
use ZhyuVueCurd\Service\Admin\System\MenuService;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Request;
use ZhyuVueCurd\Http\Controllers\CRULInterface;
use ZhyuVueCurd\Http\Controllers\CRULTrait;
use ZhyuVueCurd\Http\Controllers\CrulController;

class MenuController extends CrulController implements CRULInterface
{
    use CRULTrait;

    protected $module = 'admin';
    protected $tag = 'system.menu';

    /*
     * Service 設定
     */
    public function service()
    {

        return MenuService::class;
    }

    /*
     * 列表
     */
    public function index(){
        $this->authorize('system_menu:read');

        $parent_id = Request::get('parent_id');
        if(is_null($parent_id)){

            return redirect(url()->current().'?parent_id=0');
        }

        $this->tableBind($this->module, $this->tag)->index();

        return $this->view('ZhyuVueCurd::'.$this->module.'.'.$this->tag.'.index', ['parent_id' => $parent_id]);
    }

    /*
     * 新增
     */
    public function create(){
        $this->authorize('system_menu:create');

        $parent_id = (int) Request::get('parent_id');
        $menu = new Menu();
        $menu->parent_id = $parent_id;
        $menu->orderby = 1;

        $this->tableBind($this->module, $this->tag)->form($menu);

        return $this->view('ZhyuVueCurd::'.$this->module.'.'.$this->tag.'.form', ['parent_id' => $parent_id]);
    }


    /*
     * 刪除
     */
    public function destroy(int $id){
        $this->authorize('system_menu:delete');

        $service = app($this->service());
        $model = $service->findById($id);
        if($model->children()->count() > 0){

            return $this->responseError('此選單下面尚有子項目，無法刪除', 405);
        }

        if($model->is_can_delete==0){

            return $this->responseError('此選單無法刪除', 405);
        }
        $this->validateModel($model);

        $lock = Cache::lock($this->cacheKey() , $this->seconds);
        try {
            if ($lock->get()) {
                $res = $service->destroy($model);


                return $res;
            }

            return $this->responseError('多次執行，請過 ' . $this->seconds . ' 秒後再試', 406);
        }catch (\Exception $e){
            $msg = env('APP_DEBUG') === true ? $e->getMessage() : null;
            $this->logException($e);

            return $this->error($msg);
        }
    }
}
