<?php


namespace ZhyuVueCurd\Service\Table\Column;



class Date extends Input implements InterfaceColumn
{
    use TraitColumn;

    public function __toString(){
        $str = $this->ValidationProviderHeader();

        $str.='
        <b-field label="'.$this->name.'">
            <b-datepicker
                v-model="Model.'.$this->field.'"
                locale="zh"
                placeholder="Click to select..."
                icon="calendar-today"
                trap-focus>
            </b-datepicker>
        </b-field>';


        $str.=$this->ValidationProviderFooter();



        return $str;
    }
}
