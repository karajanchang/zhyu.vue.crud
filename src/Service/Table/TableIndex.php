<?php


namespace ZhyuVueCurd\Service\Table;


use Illuminate\Contracts\Support\Arrayable;

class TableIndex extends TableAbstract implements InterfaceTable
{
    protected $table_type = 'index';

    public function header() : string{
        $config_draggable = '
            draggable
            @dragstart="dragstart"
            @drop="drop"
            @dragover="dragover"
            @dragleave="dragleave"
        ';

        $this->header = '
            <b-table
                '.$config_draggable.'
                :data="data"
                :loading="loading"
                paginated
                backend-pagination
                hoverable
                :total="total"
                :per-page="15"
                @page-change="onPageChange"
                aria-next-label="Next page"
                aria-previous-label="Previous page"
                aria-page-label="Page"
                aria-current-label="Current page"

                backend-sorting
                :default-sort-direction="defaultSortOrder"
                :default-sort="[sortField, sortOrder]"
                @sort="onSort"

                backend-filtering
                @filters-change="onFilter"
                >
        ';

        return $this->header;
    }

    public function start() : string{
        $this->start = '<template slot-scope="props">';

        return $this->start;
    }

    public function end() : string{
        $this->end = '</template>';

        return $this->end;
    }

    public function footer() : string{
        $this->footer = '</b-table>';

        return $this->footer;
    }

    public function defaultOrderby(){

        if(isset($this->config['orderby'])) {
            return 'window.defaultOrderby =' . json_encode($this->config['orderby']) . ';';
        }

        return '';
    }

    public function buttons() : string{
        $tag = 'index_buttons';
        $width = $this->config[$tag]['width'] ?? 200;
        $str ='
            <b-table-column label="" width="'.$width.'">
                <section>
                    '.$this->makeButtons(ButtonIndex::class, $tag).'
                </section>
            </b-table-column>
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
            $allColumns = $this->getTableColumns($this->model->getTable());
            foreach ($this->columns as $field => $column){
                if(!in_array($field, $allColumns)){
                    continue;
                }
                $str.= $this->column($field);
                //dd($this->columns, $field, $column, $allColumns);
            }
            $str.= $this->buttons();
        }

        $str.= $this->end();
        $str.= $this->footer();

        return $str;
    }

}
