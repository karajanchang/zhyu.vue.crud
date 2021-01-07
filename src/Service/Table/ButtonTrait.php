<?php


namespace ZhyuVueCurd\Service\Table;


use Illuminate\Database\Eloquent\Model;

trait ButtonTrait
{
    private $model;
    private $table_name;
    private $type;
    private $params = [];

    public function __construct(Model $model , string $type, array $params)
    {
        $this->model = $model;
        $this->table_name = $model->getTable();
        $this->model_name = $this->getModelName();

        $this->type = $type;
        $this->params = $params;
    }


    private function getModelName(){
        $a = explode('\\', get_class($this->model));

        return array_pop($a);
    }

    
}
