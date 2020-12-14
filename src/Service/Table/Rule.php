<?php


namespace ZhyuVueCurd\Service\Table;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\Rule as LaravelRule;

class Rule
{
    private $rules;
    private $model;
    private $field;
    private $items_client = ['required', 'email', 'min', 'max', 'size', 'alpha', 'between', 'digits', 'integer', 'regex', 'not_in', 'numeric', 'ip', 'credit_card', 'length', 'url'];
    private $items_server = ['required', 'email', 'min', 'max', 'size', 'alpha', 'between', 'digits', 'integer', 'regex', 'not_in', 'password', 'same', 'unique', 'exists', 'in_array', 'extension', 'array', 'boolean', 'distinct', 'nullable', 'confirmed', 'ip', 'numeric', 'url'];
    private $type = 'client';

    public function __construct($rules, Model $model, string $field)
    {
        if(is_string($rules)){
            $this->rules = $this->rules_string2array($rules);
        }else{
            if(isset($rules[0]) && is_string($rules[0]) && strstr($rules[0], '|')) {
                $this->rules = $this->rules_string2array($rules[0]);
            }else{
                $this->rules = $rules;
            }
        }
        $this->model = $model;
        $this->field = $field;
    }

    public function server(){
        $this->type = 'server';

        return $this;
    }

    public function output(){

        return $this->getRulesByType();
    }


    public function __toString()
    {
        $rules = $this->getRulesByType();

        return join('|', $rules);
    }

    private function rules_string2array(string $rules){

        return explode('|', $rules);
    }

    private function getRulesByType(){
        $items = $this->type ==='server' ? $this->items_server : $this->items_client;
        $rules = [];
        array_map(function($rule) use($items, &$rules){
            $erule = explode(':', $rule);
            if(in_array($erule[0], $items)) {
                array_push($rules, $this->processRule($rule));
            }
        }, $this->rules);


        return $rules;
    }

    private function processRule($rule){
        if($rule=='unique'){
            if(!empty($this->model->id)){

                return LaravelRule::unique($this->model->getTable(), $this->field)->ignore($this->model->id);
            }else{

                return LaravelRule::unique($this->model->getTable(), $this->field);
            }
        }

        return $rule;
    }

    /*
    public function offsetExists($offset){

        return isset($this->attributes[$offset]);
    }

    public function offsetGet($offset){

        return $this->attributes[$offset];
    }

    public function offsetSet($offset, $value){

        $this->attributes[$offset] = $value;
    }

    public function offsetUnset($offset){

        unset($this->attributes[$offset]);
    }
    */

}
