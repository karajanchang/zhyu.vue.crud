<?php


namespace ZhyuVueCurd\Service\Table\Column;



class File extends Input implements InterfaceColumn
{
    use TraitColumn;

    public function __toString(){
        $dir = $this->getModelName();
        $str='<div class="field mt-4 mb-4"><label class="label">'.$this->name.'</label><div class="control">';

        $str.='<input type="file" @change="uploadFile(\''.$dir.'\',\''.$this->field.'\')" ref="'.$this->field.'">';

        if($action=='edit') {
            $str .= '<b-field><a href="window.open(\'/storage/\'+Model.' . $this->field . '\')">開新窗預覧</a></b-field>';
        }

        $str.='</div></div>';

        return $str;
    }
}
