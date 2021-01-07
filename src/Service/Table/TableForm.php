<?php


namespace ZhyuVueCurd\Service\Table;



class TableForm extends TableAbstract implements InterfaceTable
{
    protected $table_type = 'form';

    public function header() : string{
        $this->header = '<ValidationObserver v-slot="{ invalid }" ref="observer">';

        return $this->header;
    }

    public function start() : string{
        $this->start = '<form @submit.prevent="onSubmit">';

        return $this->start;
    }

    public function end() : string{
        $this->end = '</form>';

        return $this->end;
    }

    public function footer() : string{
        $this->footer = '</ValidationObserver>';

        return $this->footer;
    }

    public function buttons() : string{
        $tag = 'form_buttons';
        $width = $this->config[$tag]['width'] ?? 200;

        $str ='
            <div class="buttons">
                    '.$this->makeButtons(ButtonForm::class, $tag).'
            </div>
        ';

        return $str;
    }

    /*
     *  輸出表單
     * @return string
     */
    public function table() : string{
        $str = $this->header();
        $str.= $this->start();
        if(count($this->columns)) {
            foreach ($this->columns as $field => $column){
                $str.= $this->column($field);
            }
            $str.= $this->buttons();
        }

        $str.= $this->end();
        $str.= $this->footer();

        return $str;
    }







}
