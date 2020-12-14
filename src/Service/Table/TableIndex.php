<?php


namespace ZhyuVueCurd\Service\Table;


use Illuminate\Contracts\Support\Arrayable;

class TableIndex extends TableAbstract implements InterfaceTable
{
    protected $table_type = 'index';

    public function header() : string{

        $this->header = '
            <b-table
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

    private function makeButton($type) : ?ButtonIndex{
        if(!isset($this->config['index_buttons'][$type])){

            return null;
        }
        return app(ButtonIndex::class, [ 'model' => $this->model, 'type' => $type, 'params' => $this->config['index_buttons'][$type]  ]);
    }

    public function buttons() : string{
        $str ='
            <b-table-column label="" width="200">
                    <section>
                    '.$this->makeButton('update').'
                    '.$this->makeButton('delete').'
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
            }
            $str.= $this->buttons();
        }

        $str.= $this->end();
        $str.= $this->footer();

        return $str;
    }







}
