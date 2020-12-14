<?php


namespace ZhyuVueCurd\Service\Table\Column;


class Select extends Input implements InterfaceColumn
{
    public function __toString(){
        $str = $this->ValidationProviderHeader();

        $str.='<b-field label="'.$this->name.'"'.$this->ValidationProviderField().'>
                    <b-select type="select" v-model="Model.'.$this->field.'" placeholder="請選擇'.$this->name.'">'.$this->getOptions().'</b-input>
               </b-field>';

        $str.=$this->ValidationProviderFooter();

        return $str;
    }

    private function getOptions(){
        if(is_array($this->values) && count($this->values)){

            return $this->valuesLoop();
        }
        if(!is_array($this->relation)){

            return '';
        }

        return '
            <option
                    v-for="option in this.'.$this->relation['name'].'s"
                    :value="option.id"
                    :key="option.id">
                    {{ option.'.$this->relation['column'].' }}
                </option>
            ';
    }

    private function valuesLoop(){
        $str='';
        foreach($this->values as $key => $value){
            $str.='
                <option
                    :value="'.$value.'"
                    :key="'.$key.'">
                    '.$value.'
                </option>
            ';
        }

        return $str;
    }

}
