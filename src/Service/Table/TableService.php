<?php


namespace ZhyuVueCurd\Service\Table;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;

class TableService
{
    private $config;
    public $model;
    private $module;
    private $tag;
    private static $service;

    /**
     * TableService constructor.
     * @param string|null $module
     * @param string|null $tag
     * @throws \Exception
     */
    public function __construct(string $module = null, string $tag = null)
    {
        $this->module = $module;
        $this->tag = $tag;

        $dir = 'columns';
        if(!is_null($module)){
            $dir .= '.' . $module;
        }
        if(!is_null($tag)){
            $dir .= '.' . $tag;
        }

        $config = config($dir);
        if(!is_null($config)){
            $this->config = $config;
        }else{
            $tag = 'zhyu.crud.'.$tag;
            $this->config = config($tag);
        }

        if(is_null($this->config)){
            throw new \Exception('Please create config of columns schema first!');
        }

        return $this;
    }

    /**
     * @return $this
     */
    public function index(){
        App::bind(InterfaceTable::class, TableIndex::class);
        $this->makeModel();

        return $this;
    }

    /**
     * @param Model|null $model
     * @return $this
     */
    public function form(Model $model = null){
        App::bind(InterfaceTable::class, TableForm::class);
        $this->makeModel($model);

        return $this;
    }

    /**
     * @param Model|null $model
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    private function makeModel(Model $model = null){
        $this->model = $model;
        if(is_null($model)) {
            $this->model = app()->make($this->config['model']);
        }
    }

    /**
     * @return mixed|InterfaceTable
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    private function getServiceInstance(){
        if(self::$service===null) {
            self::$service = app()->make(InterfaceTable::class, ['config' => $this->config, 'model' => $this->model, 'module' => $this->module, 'tag' => $this->tag ]);
        }

        return self::$service;
    }

    /**
     * @param $name
     * @param $arguments
     * @return mixed
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function __call($name, $arguments)
    {
        return $this->getServiceInstance()->{$name}($arguments);
    }
}
