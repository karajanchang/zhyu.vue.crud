<?php


namespace ZhyuVueCurd\Service\Table;


use Carbon\Carbon;
use http\QueryString;
use Illuminate\Support\Facades\Schema;
use ZhyuVueCurd\Helper\GetTableColumnsTrait;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Database\Eloquent\Model;

class TableAbstract implements \ArrayAccess, Arrayable
{
    use GetTableColumnsTrait;
    //---index or form
    protected $table_type = 'index';

    protected $config;
    protected $model;
    protected $title;
    protected $columns = [];

    protected $header = '';
    protected $start = '';
    protected $end = '';
    protected $footer = '';
    protected $js2 = '';

    public function __construct($config = null, Model $model = null)
    {
        $this->config = $config;
        $this->model = $model;
        $this->parseArray();
    }

    protected function parseArray(){
        if(!isset($this->config['columns'])) throw new \Exception('config error: no columns!');

        if(count($this->columns)){

            return ;
        }

        foreach($this->config['columns'] as $field => $rows){
            $column = new Column($this->table_type, $this->model);
            $column->field = $field;
            foreach($rows as $type => $row) {
                $column->{$type} = ($row);
            }
            $this->columns[$field] = $column;
        }
    }

    public function rulesCombined(){
        $rules = $this->rules();
        $combined_rules = [];
        foreach($rules as $field => $rule){
            $combined_rules[$field] = join('|', $rule);
        }

        return $combined_rules;
    }

    public function rules($field = null){
        if(is_array($field) && count($field)){

            return $this->column($field[0])->getRules();
        }else{
            $rules = [];
            foreach($this->columns as $field => $cc){
                $rules[$field] = $this->column($field)->getRules();
            }

            return $rules;
        }
    }

    public function title(){

        return $this->config['title'];
    }

    public function js(){
        $this->makeJs2($this->columns);

        $columns = $this->makeColumn();
        $ccs = [];
        $js = 'window.Model={';
        foreach($columns as $column => $value){
            if(isset($this->config['columns'][$column]['type']) && strtolower($this->config['columns'][$column]['type'])=='date'){
                if(isset($columns['id'])) {
                    $ccs[] = '"' . $column . '": ' . 'new Date(\'' . $value . '\')';
                }else{
                    $ccs[] = '"' . $column . '": ' . 'new Date()';
                }
            }else{
                if(is_string($value)) {
                    $ccs [] = '"' . $column . '": "' . $value . '"';
                }elseif(is_null($value)){
                    $ccs [] = '"' . $column . '": "' . $value . '"';
                }else{
                    $ccs [] = '"' . $column . '": ' . $value;
                }
            }
        }

        $js .= join(',', $ccs).'};';

        $js .= 'window.ckeditorColumns = [\'body\'];';

//        return 'window.Model ='. json_encode($columns);
        return $js;
    }


    protected function makeButtons(string $buttonClass, string $tag) : ?string{
        if(!isset($this->config[$tag]) && !is_array($this->config[$tag])) return null;

        $str = '<div class="buttons">';
        array_map(function($configs) use($buttonClass, &$str){
            if(is_array($configs)) {
                $type = $configs['type'] ?? 'primary';
                $str .= app($buttonClass, ['model' => $this->model, 'type' => $type, 'params' => $configs]);
            }
        }, $this->config[$tag]);
        $str .= '</div>';

        return $str;
    }

    private function makeColumn() : array{
        $columns = [
            'id' => !empty($this->model->id) ? $this->model->id : null,
        ];
        foreach($this->columns as $column => $dd){
            /*
            if($column=='colors'){
                dd($dd);
                dd($dd, $this->model, $this->model->{$column}, $this->columns);
            }
            */
            $relation = $this->model->{$column};
            if(method_exists($this->model, $column)){
                if($relation->count()) {
                    foreach ($relation as $bb) {
                        $columns[$column][] = $bb->id;
                    }
                }else{
                    $columns[$column] = [];
                }
            }else {
                $columns[$column] = !empty($relation) ? $relation : null;
            }
        }
        //dd($columns);

        return $columns;
    }

    private function makeJs2(){
        $js_selects = [];
        foreach($this->columns as $column => $dd) {
            if (is_array($dd->relation) && !empty($dd->relation['table']) && !empty($dd->relation['column']) && !empty($dd->relation['name'])) {
                $url = url(route('vendor.ajax.select', [
                                                                'table' => $dd->relation['table'],
                                                                'column' => $dd->relation['column'],
                                                            ],
                        ));
                //$consoleLog = env('APP_DEBUG')===true ? 'console.log(res.data);' : '';
                $consoleLog = '';
                $js_selects[] = "axios.get('" . $url . "').then((res) => { window." . $dd->relation['name'] . "s = res.data; " . $consoleLog . " })";
            }
        }
        $this->js2 = count($js_selects) ? join(";\n", $js_selects)."\n": '';
    }

    public function js2(){

        return $this->js2;
    }

    public function offsetExists($offset){

        return isset($this->columns[$offset]);
    }

    public function offsetGet($offset){

        return $this->columns[$offset];
    }

    public function offsetSet($offset, $value){

        $this->columns[$offset] = $value;
    }

    public function offsetUnset($offset){

        unset($this->columns[$offset]);
    }

    public function toArray()
    {
        return $this->columns;
    }

    public function column(string $column){
        $column = $this->columns[$column];

        return $column;
    }
}


