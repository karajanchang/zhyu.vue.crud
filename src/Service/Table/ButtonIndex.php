<?php


namespace ZhyuVueCurd\Service\Table;


use Illuminate\Database\Eloquent\Model;

class ButtonIndex
{
    private $model;
    private $table_name;
    private $type;
    private $params = [];

    public function __construct(Model $model , string $type, array $params)
    {
        $this->model = $model;
        $this->table_name = $model->getTable();
        $this->type = $type;
        $this->params = $params;
    }

    private function makeUrl(){
        $default_url = $this->type == 'update' ? '/'.$this->table_name.'/edit' : '/'.$this->table_name.'/{id}';
//        dd(url($this->params['url']), $default_url);

        return isset($this->params['url']) ?  url($this->params['url']) : url($default_url);
    }

    private function makeCss(){
        $default_css = $this->type == 'update' ? 'is-info' : 'is-danger';

        return isset($this->params['css']) ?  $this->params['css'] : $default_css;
    }

    public function __toString()
    {
        $is_delete = $this->type=='delete' ? 'true' : 'false';
        return  '<b-button @click="buttonUrl(\''.$this->makeUrl().'\', props.row, \'id\', '.$is_delete.')" type="'.$this->makeCss().'"> '.$this->params['label'].'</b-button>';
    }

}
