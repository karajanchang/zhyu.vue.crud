<?php


namespace ZhyuVueCurd\Service\Table\Column;


class Textarea extends Input
{
    use TraitColumn;


    public function __toString(){
        $str = $this->ValidationProviderHeader();

        $str.='<b-field label="'.$this->name.'"'.$this->ValidationProviderField().'>
                    <b-input type="textarea" v-model="Model.'.$this->field.'" placeholder="請輸入'.$this->name.'" autocomplete="new-'.$this->field.'" ></b-input>
               </b-field>';

        $str.=$this->ValidationProviderFooter();

        return $str;
    }
}
