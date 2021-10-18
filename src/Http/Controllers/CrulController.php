<?php
namespace App\Http\Controllers\Admin\Announcement;


use App\Models\Board;
use App\Models\BoardItem;
use App\Service\Admin\Announcement\BoarditemService;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Request;
use ZhyuVueCurd\Http\Controllers\CRULInterface;
use ZhyuVueCurd\Http\Controllers\CRULTrait;
use ZhyuVueCurd\Http\Controllers\CrulController;

class BoarditemController extends CrulController implements CRULInterface
{
    use CRULTrait;

    protected $module = 'admin';
    protected $tag = 'announcement.boarditem';

    /*
     * Service 設定
     */
    public function service()
    {

        return BoarditemService::class;
    }

    /*
     * 列表
     */
    public function index(){
        $this->authorize('announcement_board:read');

        $board_id = Request::get('board_id');
        if(is_null($board_id)){

            return redirect(route('admin.announcement.board.index'));
        }

        $this->tableBind($this->module, $this->tag)->index();

        return $this->view('admin.announcement.boarditem.index', compact('board_id'), Request::all());
    }

    /*
     * 新增
     */
    public function create(){
        $this->authorize('announcement_board:create');

        $board_id = (int) Request::get('board_id');
        $boardItem = new BoardItem();
        $boardItem->board_id = $board_id;

        $this->tableBind($this->module, $this->tag)->form($boardItem);

        return $this->view('ZhyuVueCurd::'.$this->module.'.'.$this->tag.'.form', ['board_id' => $board_id], Request::all());
    }

    /*
     * 儲存
     */
    public function store(\Illuminate\Http\Request $request){
        $this->authorize('announcement_board:create');

        $this->tableBind($this->module, $this->tag)->form();

        $this->validate($request, $this->rules_store());

        $lock = Cache::lock($this->cacheKey() , $this->seconds);
        try {
            if ($lock->get()) {
                $res = app($this->service())->store();

                return $res;
            }

            return $this->responseError('多次執行，請過 ' . $this->seconds . ' 秒後再試', 406);
        }catch (\Exception $e){
            $msg = env('APP_DEBUG') === true ? $e->getMessage() : null;
            $this->logException($e);

            return $this->error($msg);
        }
    }

    /*
     * 修改
     */
    public function edit(int $id){
        $this->authorize('announcement_board:edit');

        $model = app($this->service())->findById($id);

        $this->tableBind($this->module, $this->tag)->form($model);
        $this->validateModel($model);

        $tags = explode('.', str_replace('-', '_', $this->tag));
        $tag = $tags[ (count($tags)-1)];


        $this->setEditUrl(route($this->module.'.'.$this->tag.'.update', [ $tag => $model ]));

        return $this->view($this->module.'.'.$this->tag.'.form', [], Request::all());
    }

    /*
     *  更新
     */
    public function update(int $id, \Illuminate\Http\Request $request)
    {
        $this->authorize('announcement_board:edit');

        $model = app($this->service())->findById($id);
        $this->tableBind($this->module, $this->tag)->form($model);
        $this->validateModel($model);

        $this->validate($request, $this->rules_update($model));

        $lock = Cache::lock($this->cacheKey() , $this->seconds);
        try {
            if ($lock->get()) {
                $res = app($this->service())->update($model);
                Log::info(__CLASS__.'::'.__METHOD__.' res: ', [$res]);

                return $res;
            }

            return $this->responseError('多次執行，請過 ' . $this->seconds . ' 秒後再試', 406);
        }catch (\Exception $e){
            $msg = env('APP_DEBUG') === true ? $e->getMessage() : null;
            $this->logException($e);

            return $this->error($msg);
        }
    }

    /*
     * 刪除
     */
    public function destroy(int $id){
        $this->authorize('announcement_board:delete');

        $service = app($this->service());
        $model = $service->findById($id);
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
