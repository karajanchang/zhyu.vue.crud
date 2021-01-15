<?php


namespace ZhyuVueCurd\Service\Table\Column;



class Image extends Input implements InterfaceColumn
{
    use TraitColumn;

    public function __toString(){
        $dir = $this->getModelName();
        $action = $this->getAction();
        $str='<div class="field mt-4 mb-4"><label class="label">'.$this->name.'</label><div class="control">';

        $str.='<input type="file" @change="uploadFile(\''.$dir.'\',\''.$this->field.'\')" ref="'.$this->field.'">';

        if($action=='edit') {
            $str .= '<b-image :src="getImgUrl(\'/storage/\'+Model.' . $this->field . ')"></b-image>';
        }

        $str.='</div></div>';

        return $str;
    }
}
