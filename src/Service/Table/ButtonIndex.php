<?php


namespace ZhyuVueCurd\Service\Table;


use Illuminate\Database\Eloquent\Model;

class ButtonIndex
{
    use ButtonTrait;

    
    private function makeUrl(){
        $default_url = $this->type == 'update' ? '/'.strtolower($this->model_name).'/edit' : '/'.strtolower($this->model_name).'/{id}';

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
