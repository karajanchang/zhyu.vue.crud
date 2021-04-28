<?php


namespace ZhyuVueCurd\Service\Table\Column;


class Input implements InterfaceColumn
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
        $str = $this->ValidationProviderHeader();

        $str.='<b-field label="'.$this->name.'"'.$this->ValidationProviderField().'>
                    <b-input type="text" v-model="Model.'.$this->field.'" placeholder="請輸入'.$this->name.'" autocomplete="new-'.$this->field.'"></b-input>
                    '.$this->description.'
               </b-field>';

        $str.=$this->ValidationProviderFooter();

        return $str;
    }

    protected function ValidationProviderHeader(){
        if($this->rules_only_backend===true){

            return '';
        }

        return '<ValidationProvider rules="' . $this->rule . '" name="' . $this->name . '" v-slot="{ errors, valid }">';
    }


    protected function ValidationProviderFooter(){
        if($this->rules_only_backend===true){

            return '';
        }

        return '</ValidationProvider>';
    }

    protected function ValidationProviderField(){
        if($this->rules_only_backend===true){

            return '';
        }

        return ':type="{ \'is-danger\': errors[0], \'is-success\': valid }" :message="errors"';
    }
}
