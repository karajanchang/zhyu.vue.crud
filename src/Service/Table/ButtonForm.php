<?php


namespace ZhyuVueCurd\Service\Table;


use Illuminate\Database\Eloquent\Model;

class ButtonForm
{
    use ButtonTrait;


    private function makeUrl(){
        $default_url = $this->type == 'cancel' ? '/'.$this->model_name : null;

        return isset($this->params['url']) ?  url($this->params['url']) : ($default_url);
    }

    private function makeCss(){
        $default_css = $this->type == 'cancel' ? 'is-primary' : 'is-info';

        return isset($this->params['css']) ?  $this->params['css'] : $default_css;
    }

    public function __toString()
    {
        if($this->type=='submit') {

            return '<b-button type="' . $this->makeCss() . '" native-type="submit"> ' . $this->params['label'] . '</b-button>';
        }else{

            return '<b-button type="' . $this->makeCss() . '" onclick="location.href=\''.$this->makeUrl().'\'"> ' . $this->params['label'] . '</b-button>';
        }
    }

}
