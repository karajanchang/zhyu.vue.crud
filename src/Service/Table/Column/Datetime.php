<?php


namespace ZhyuVueCurd\Service\Table\Column;



class Datetime extends Input implements InterfaceColumn
{
    use TraitColumn;

    public function __toString(){
        $str = $this->ValidationProviderHeader();

        $str.='
        <b-field label="'.$this->name.'">
            <b-datetimepicker
                v-model="Model.'.$this->field.'"
                locale="zh"
                placeholder="Click to select..."
                >
            </b-datetimepicker>
        </b-field>';


        $str.=$this->ValidationProviderFooter();



        return $str;
    }
}
