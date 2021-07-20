<?php


namespace ZhyuVueCurd\Service\Table\Column;


class Richtext extends Input implements InterfaceColumn
{
    use TraitColumn;

    public function __toString(){
        $dir = $this->getModelName();
        $str='<div class="field mt-4 mb-4"><label class="label">'.$this->name.'</label><div class="control">';

        //--ckeditor
       if(env('WYSIWYG_EDITOR', 'froala')=='ckeditor') {
            $str .= '<textarea ref="' . $this->field . '" rows="20" style="width:100%;" id="' . $this->field . '"></textarea>' . $this->description;
        }else{
            $str .= '<textarea ref="' . $this->field . '" rows="20" style="width:100%;" id="' . $this->field . '" v-model="Model.' . $this->field . '"></textarea>' . $this->description;
        }


        $str.='</div></div>';

        return $str;
    }

}
