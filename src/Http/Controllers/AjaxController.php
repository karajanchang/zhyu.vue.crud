<?php


namespace ZhyuVueCurd\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Zhyu\Facades\ZhyuTool;
use Zhyu\Repositories\Eloquents\Repository;
use ZhyuVueCurd\Helper\GetTableColumnsTrait;

class AjaxController extends Controller
{
    use GetTableColumnsTrait;

    private $request;
    private $config;
    private $table;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }



    public function index($module, $tag = null){
        $capFunctionName = $this->capName($tag);

        if(method_exists($this, $capFunctionName)){

            return $this->{$capFunctionName}();
        }
        $repository = $this->getRepository($capFunctionName, $module);
        if(!class_exists($repository)) throw new \Exception('Please create repository class first: '.$repository);

        $qb = $this->parseSelect($tag, $repository, $module);

        return $this->rowsOrderby($qb);
    }

    /*
     * 拿到repository
     */
    private function getRepository($capFunctionName, $module = null) : string{
        if(strstr($capFunctionName, '.')) {
            $caps = explode('.', $capFunctionName);
            $repository = 'App\Repositories'.'\\'.$module;
            foreach ($caps as $cap) {
                $repository .= '\\' . $this->parseIfHasDot($cap);
            }
            $repository .= 'Repository';
            if (class_exists($repository)) {

                return $repository;
            }

            $capFunctionName = $this->parseIfHasDot($capFunctionName, $module);
            $repository = 'App\Repositories\\' . $capFunctionName . 'Repository';

        }else{
            $repository = 'App\Repositories\\'.$module.'\\'.$capFunctionName.'Repository';
        }

        return $repository;
    }

    /*
     * 若其值為 material.brand  ==> MaterialBrand
     */
    private function parseIfHasDot($capFunctionName, $module = null, bool $isUcFirst = true, bool $isAsFolder = false) : string{
        if(!is_null($module)){
            $capFunctionName = $module.'.'.$capFunctionName;
        }

        $capFunctionNames = explode('.', $capFunctionName);
        $replace = $isAsFolder===true ? '/' : '';
        $res = join($replace,
            array_map(function ($row) use($isUcFirst){
                if($isUcFirst===true) {

                    return ucfirst($row);
                }

                return $row;
            }, $capFunctionNames));

        return $res;
    }

    public function select($table, $column){

        return DB::table($table)->select('id', $column)->orderby($column, 'asc')->get()->all();
    }


    private function parseSelect(string $tag, string $repository, string $module = null){
        $tag = $this->parseIfHasDot($tag, $module, false, true);

        $this->config = include base_path('config/columns/'.$tag.'.php');
        $rep = app($repository);
        if(isset($this->config['joins']) && count($this->config['joins'])){
            $qb = $rep->getModel();
            $this->table = $qb->getTable();
            $columns = $this->getTableColumns($this->table);
            $selects = [];
            foreach($this->config['columns'] as $col => $column){
                if(!in_array($col, $columns)){
                    continue;
                }
                if(isset($column['relation'])) {
                    $col = DB::raw($column['relation']['table'] . '.' . $column['relation']['column'] . ' as ' . $col);
                }else{
                    $col = $this->table.'.'.$col;
                }
                if(count($selects)==0){
                    array_push($selects, $this->table.'.id');
                }
                array_push($selects, $col);

            }

            foreach($this->config['joins'] as $col => $joins){
                $qb = call_user_func_array([$qb, 'join'], $joins);
            }

            $qb = $qb->select($selects);
        }else{
            $this->table = $rep->makeModel()->getTable();
            $qb = $rep->select(['*']);
        }

        return $qb;
    }



    private function rowsOrderby($qb){
        if($qb instanceof Repository){
            $qb = $qb->getModel();
        }
        //dd($qb);
        $all = $this->request->all();
        $orderbys = [];
        if(isset($all['orderby'])){
            $orderbys = explode('.', $all['orderby']);
        }
        if(count($orderbys)){
            $qb->orderby($this->table.'.'.$orderbys[0], $orderbys[1]);
        }
        if(isset($all['filter'])) {
            $filter = json_decode(urldecode($all['filter']));
            if (is_object($filter)) {
                foreach($filter as $key => $c) {
                    if(isset($this->config['columns'][$key]['relation'])) {
                        $relation = $this->config['columns'][$key]['relation'];
                        $qb->where($relation['table'] . '.' . $relation['column'], 'like', '%' . $c . '%');
                    }else {
                        $qb->where($this->table . '.' . $key, 'like', '%' . $c . '%');
                    }
                }
            }
        }
        //dump($qb, 'GGGGGG');
        if(isset($all['query'])) {
            $this->processQuery($qb, $all['query']);
        }
//        dd($qb->toSql(), $qb->getBindings());
        $rows = $qb->paginate();

        return $rows;
    }

    private function processQuery($qb, string $query = null){
        if(is_null($query)) return ;

        $querys = ZhyuTool::urlMakeQuery('#')->decode($query);
        foreach($querys as $column => $qs) {
            $qb->where($column, $qs['0'], $qs['1']);
        }
    }

}
