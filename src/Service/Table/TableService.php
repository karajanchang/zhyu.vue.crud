<?php


namespace ZhyuVueCurd\Service\Table;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;

class TableService
{
    private $config;
    public $model;
    private static $service;

    public function __construct(string $tag)
    {
        $this->config = config('columns.'.$tag);
        if(is_null($this->config)){
            throw new \Exception('Please create config of columns schema first!');
        }

        return $this;
    }

    public function index(){
        App::bind(InterfaceTable::class, TableIndex::class);
        $this->makeModel();

        return $this;
    }

    public function form(Model $model = null){
        App::bind(InterfaceTable::class, TableForm::class);
        $this->makeModel($model);

        return $this;
    }

    private function makeModel(Model $model = null){
        $this->model = $model;
        if(is_null($model)) {
            $this->model = app()->make($this->config['model']);
        }
    }

    private function getServiceInstance(){
        if(self::$service===null) {
            self::$service = app()->make(InterfaceTable::class, ['config' => $this->config, 'model' => $this->model]);
        }

        return self::$service;
    }

    public function __call($name, $arguments)
    {
        return $this->getServiceInstance()->{$name}($arguments);
    }
}
