<?php


namespace ZhyuVueCurd\Service\Table;


use ZhyuVueCurd\Service\Table\Column\ColumnApp;
use ZhyuVueCurd\Service\Table\Column\ColumnService;
use Illuminate\Database\Eloquent\Model;

class Column implements \ArrayAccess
{
    private $field;
    private $name;
    private $type;
    private $rules = [];
    private $params = [];
    private $attribues = [];
    private $table_type = 'index';
    private $model;
    private $relation;
    private $values; //radio或checkbox的內容
    private $rules_only_backend = false;

    public function __construct(string $table_type, Model $model = null)
    {
        $this->table_type = $table_type;
        $this->model = $model;
    }


    public function offsetExists($offset){

        return isset($this->attribues[$offset]);
    }

    public function offsetGet($offset){

        return $this->attribues[$offset];
    }

    public function offsetSet($offset, $value){

        $this->attribues[$offset] = $value;
    }

    public function offsetUnset($offset){

        unset($this->attribues[$offset]);
    }

    public function __set($name, $value)
    {
        $this->{$name} = $value;
    }

    public function __get($name)
    {
        return $this->{$name};
    }

    private function params2string() : string{
        $items = [];
        foreach($this->params as $key => $val){
            if(!is_int($key)){
                $items[] = $key.'="'.$val.'"';
            }else{
                $items[] = $val;
            }
        }

        return join(' ', $items);
    }

    public function __toString()
    {
        if($this->table_type=='form'){

            return $this->__toStringForm();
        }

        return $this->__toStringIndex();
    }

    private function parseRules(){
        if(!empty($this->model->id)){
            if(isset($this->rules['update'])){
                $rules = $this->rules['update'];
            }else{
                $rules = $this->rules;
            }
        }else{
            if(isset($this->rules['store'])){
                $rules = $this->rules['store'];
            }else{
                $rules = $this->rules;
            }
        }

        return $rules;
    }
    private function makeRule(){
        $rules = $this->parseRules();

        return new Rule($rules, $this->model, $this->field);
    }

    /*
    private function type2str($type){
        switch($type){
            case 'text':
                $s = 'input';
                break;
            case 'email':
                $s = 'input';
                break;
            case 'password':
                $s = 'input';
                break;
            default:
                $s = $type;
        }

        return $s;
    }
    */

    public function getRules(){
        $rule = $this->makeRule()->server()->output();

        return $rule;
    }

    private function __toStringForm(){
        if(isset($this->display_form) && $this->display_form===false)  return '';

//        $st = $this->type2str($this->type);

        app(ColumnApp::class)->bind($this->type, true);
        $columnService = app(ColumnService::class);
        $columnService
                    ->name($this->name)
                    ->field($this->field)
                    ->rule($this->makeRule())
                    ->relation($this->relation)
                    ->values($this->values)
                    ->rulesOnlyBackend($this->rules_only_backend)
                    ;

        return (string) $columnService;
    }

    private function __toStringIndex(){
        if(isset($this->display_index) && $this->display_index===false)  return '';

        $paramsString = $this->params2string();

        return '
        <b-table-column field="'.$this->field.'" label="'.$this->name.'" '.$paramsString.'>
            {{ props.row.'.$this->field.' }}
        </b-table-column>
        ';
    }
}
