<?php


namespace ZhyuVueCurd\Http\Controllers;


use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\View;
use ZhyuVueCurd\Helper\TableServiceBind;
use ZhyuVueCurd\Helper\TraitLogging;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class CurlController extends Controller
{
    use TraitLogging;
    use CRULTrait;

    public $data_url = null;

    public $create_url = null;
    public $edit_url = null;
    public $index_url = null;
    public $store_url = null;

    public $tableService = null;

    //--預設module
    protected $module = '';

    //--抓tableServcie用
    protected $tag = '';

    protected $seconds = 5;

    public function __construct()
    {
        if(method_exists($this, 'createUrl')){
            $this->create_url = $this->createUrl();
        }
        if(method_exists($this, 'dataUrl')){
            $this->data_url = $this->dataUrl();
        }
        if(method_exists($this, 'indexUrl')){
            $this->index_url = $this->indexUrl();
        }
        if(method_exists($this, 'storeUrl')){
            $this->store_url = $this->storeUrl();
        }
        $this->seconds = env('ATOMIC_LOCK_A_SECONDS', 5);
    }

    protected function cacheKey() : string{
        $auth_user_id = Auth::check() ? Auth::user()->id : '';

        return env('APP_ENV') . md5(get_class($this)). $auth_user_id;
    }

    /*
     * 列表
     */
    public function index(){
        $this->tableBind($this->module, $this->tag)->index();

        return $this->view($this->module.'.'.$this->tag.'.index');
    }

    /*
     * 新增
     */
    public function create(){

        $this->tableBind($this->module, $this->tag)->form();

        return $this->view($this->module.'.'.$this->tag.'.form');
    }

    /*
     * 儲存
     */
    public function store(Request $request){
        $this->tableBind($this->module, $this->tag)->form();

        $this->validate($request, $this->rules_store());

        $lock = Cache::lock($this->cacheKey() , $this->seconds);
        try {
            if ($lock->get()) {
                $res = app($this->service())->store();

                return $res;
            }

            return $this->error('多次執行，請過 ' . $this->seconds . ' 秒後再試');
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
        $model = app($this->service())->findById($id);

        $this->tableBind($this->module, $this->tag)->form($model);
        $this->validateModel($model);

        $tags = explode('.', str_replace('-', '_', $this->tag));
        $tag = $tags[ (count($tags)-1)];

        $this->setEditUrl(route($this->module.'.'.$this->tag.'.update', [ $tag => $model ]));

        return $this->view($this->module.'.'.$this->tag.'.form');
    }



    /*
     *  更新
     */
    public function update(int $id, Request $request)
    {
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

            return $this->error('多次執行，請過 ' . $this->seconds . ' 秒後再試');
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
        $service = app($this->service());
        $model = $service->findById($id);
        $this->validateModel($model);

        $lock = Cache::lock($this->cacheKey() , $this->seconds);
        try {
            if ($lock->get()) {
                $res = $service->destroy($model);

                return $res;
            }

            return $this->error('多次執行，請過 ' . $this->seconds . ' 秒後再試');
        }catch (\Exception $e){
            $msg = env('APP_DEBUG') === true ? $e->getMessage() : null;
            $this->logException($e);

            return $this->error($msg);
        }
    }

    /*
     * Bind 一個 tatable
     */
    protected function tableBind(string $module, string $tag){
        $this->tableService = TableServiceBind::bind($module, $tag);

        return $this->tableService;
    }

    /**
     * 設定 修改submit的連結url
     * @param null $edit_url
     */
    protected function setEditUrl($edit_url): void
    {
        $this->edit_url = $edit_url;
    }

    /*
     * 駈證是不存在此筆資料
     */
    protected function validateModel(Model $row){
        if(empty($row->id)){
            return response()->withException(new \Exception('無此資料'));
        }

        return true;
    }

    /*
     * ajax呼叫 返回 錯誤
     */
    protected function responseError(string $message, int $code){

        return ['error' => [
            'message' => $message,
            'code' => $code,
        ]
        ];
    }

    /*
     * 返回view
     */
    protected function view(string $view_name, array $params = []){
        $views = explode('.', $view_name);
//        dump($view_name);

        return view()->first([
            $view_name,
            'vendor.curl.'.$views[(count($views)-1)],
            'ZhyuVueCurd::curl.'.$views[(count($views)-1)],
        ],
            array_merge(
                $params,
                $this->groupUrls(),
                [ 'tableService' => $this->tableService ],
                [ 'row' => $this->tableService->model ]
            )
        );
    }

    /*
    * 組合url
    */
    private function groupUrls() : array{

        return
            [
                'urls' => [
                    'create' => !empty($this->create_url) ? url($this->create_url) : null,
                    'data' => url($this->data_url),
                    'edit' => url($this->edit_url),
                    'index' => url($this->index_url),
                    'store' => url($this->store_url),
                ],
            ];
    }

    /*
     * 定義網址 - create
     */
    public function createUrl() : string{

        return route($this->module.'.'.$this->tag .'.create');
    }

    /*
     * 定義網址 - store
     */
    public function storeUrl() : string{

        return route($this->module.'.'.$this->tag .'.store');
    }

    /*
     * 定義網址 - data
     */
    public function dataUrl() : string{
//        dump($this->module, $this->tag);

//        dump($a);
        return route('vendor.ajax.'.$this->module.'.'.$this->tag, [ 'module' => $this->module, 'tag' => $this->tag ]);
    }

    /*
    * 定義網址 - index
    */
    public function indexUrl() : string{

        return route($this->module.'.'.$this->tag .'.index');
    }

    private function error(string $msg = null){

        return response()->json([
            'errors' => $msg
        ],
            Response::HTTP_BAD_REQUEST);
    }

    public function getModule() : string{

        return $this->module;
    }

    public function getTag() : string{

        return $this->tag;
    }

    public function getLastTag(){
        $tags = explode('.', $this->tag);

        return array_pop((array_slice($tags, -1)));
    }

    public function getModel(){

        return $this->tableService->model;
    }
}
