<?php


namespace ZhyuVueCurd\Service\Table\Column;


use Illuminate\Support\Facades\DB;

class Checkbox extends Input implements InterfaceColumn
{
    public function __toString(){
        $str = $this->ValidationProviderHeader();

        $str.='<b-field label="'.$this->name.'"'.$this->ValidationProviderField().'>
                '.$this->fieldOutput().'
               </b-field>';

        $str.=$this->ValidationProviderFooter();

        return $str;
    }

    private function fieldOutput(){
        if(is_array($this->values) && count($this->values)){

            return $this->valuesLoop();
        }

        if(is_array($this->relation)){

            return $this->relationLoop();
        }

        return '<b-checkbox v-model="Model.'.$this->field.'" placeholder="請輸入'.$this->name.'" autocomplete="new-'.$this->field.'" true-value="1" false-value="0"></b-checkbox>'.$this->description;
    }

    private function valuesLoop(){
        $str='<blockquote>';
        foreach($this->values as $key => $value){
            $str.='<div classs="block"><b-checkbox v-model="Model.'.$this->field.'" native-value="'.$key.'">'.$value.'</b-checkbox></div>';
        }
        $str.='</blockquote>';

        return $str;
    }

    private function relationLoop(){
        $rows = DB::table($this->relation['table'])->get();
        $str='';
        if($rows->count() > 0){
            $str.='<blockquote>';
            $rows->map(function($row) use(&$str){
                $col = $row->{$this->relation['column']};
                $str.='<div classs="block"><b-checkbox v-model="Model.'.$this->field.'" native-value="'.$row->id.'">'.$col.'</b-checkbox></div>';
            });
            $str.='</blockquote>';
        }

        return $str;
    }

}
