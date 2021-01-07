<?php


namespace ZhyuVueCurd\Service\Table\Column;


class Hidden implements InterfaceColumn
{
    private $attributes = [];

    public function __set($name, $value){
       $this->attributes[$name] = $value;
    }

    public function __get($name){

        return isset($this->attributes[$name]) ? $this->attributes[$name] : null;
    }

    public function toArray(){

        return $this->attributes;
    }

    public function output(bool $rules_only_backend = null) : string{
        if(!is_null($rules_only_backend) && $rules_only_backend===true){
            $this->rules_only_backend = true;
        }
        return (string) $this;
    }

    public function __toString(){
        $str='<b-field>
                    <b-input type="hidden" v-model="Model.'.$this->field.'" placeholder="請輸入'.$this->name.'" autocomplete="new-'.$this->field.'"></b-input>
               </b-field>';


        return $str;
    }


}
