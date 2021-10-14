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

    /**
     * AjaxController constructor.
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }


    /**
     * @param $module
     * @param null $tag
     * @return mixed
     * @throws \Exception
     */
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

    /**
     * @param string $repository
     * @return string|null
     */
    private function getRepositoryClass(string $repository) : ?string{
        $r = 'App'.$repository;
        if(class_exists($r)){

            return $r;
        }

        $r = 'ZhyuVueCurd'.$repository;
        if(class_exists($r)){

            return $r;
        }

        return null;
    }

    /*
     * 拿到repository
     */
    private function getRepository($capFunctionName, $module = null) : string{
        if(strstr($capFunctionName, '.')) {

            $caps = explode('.', $capFunctionName);
            $repository = '\Repositories'.'\\'.ucfirst($module);
            foreach ($caps as $cap) {
                $repository .= '\\' . $this->parseIfHasDot($cap);
            }

            $repository .= 'Repository';
            $r = $this->getRepositoryClass($repository);
            if(!is_null($r)){

                return $r;
            }

            $capFunctionName = $this->parseIfHasDot($capFunctionName, $module);
            $repository = '\Repositories\\' . $capFunctionName . 'Repository';
        }else{
            $repository = '\Repositories\\'.$module.'\\'.$capFunctionName.'Repository';
        }

        $repository = $this->getRepositoryClass($repository);

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

    /*
     * 若其值為 material.brand  ==> MaterialBrand
     */
    private function parseIfHasDotColumn($capFunctionName, $module = null, bool $isUcFirst = true, bool $isAsFolder = false) : string{
        if(!is_null($module)){
            $capFunctionName = $module.'.'.$capFunctionName;
        }

        $capFunctionNames = explode('.', $capFunctionName);

        $replace = $isAsFolder===true ? '/' : '';
        $res = join($replace,
            array_map(function ($row) use($isUcFirst){
                if($isUcFirst===true) {

                    return $row;
                }

                return $row;
            }, $capFunctionNames));

        return $res;
    }

    /**
     * @param $table
     * @param $column
     * @return array
     */
    public function select($table, $column, $from, $field, $module = null, $tag = null){

        $from = substr($from, 0, strlen($from)-1);

        $tag = $this->parseIfHasDot($tag, $module, false, true);
        $this->getConfig($tag);
        $qb = DB::table($table)->select('id', $column)->orderby($column, 'asc');
        if(isset($this->config['columns'][$field]['relation']['wheres'])) {
            $wheres = $this->config['columns'][$field]['relation']['wheres'];
            if(count($wheres)){
                foreach ($wheres as $where){
                    call_user_func_array([$qb, 'where'], $where);
                }
            }
        }

        return $qb->get();
    }

    /**
     * @param $tag
     * @return string
     */
    private function getConfig($tag){
        $file = base_path('config/columns/' . $tag . '.php');
        if(file_exists($file)){

            return $file;
        }

        $file = base_path('vendor/zhyu/vue.crud/src/config/columns/' . $tag . '.php');

        $this->config = include $file;
    }

    /**
     * @param string $tag
     * @param string $repository
     * @param string|null $module
     * @return mixed
     */
    private function parseSelect(string $tag, string $repository, string $module = null){
        $tag = $this->parseIfHasDot($tag, $module, false, true);

        /*
        $system_tags = ['admin/permission/resource', 'admin/permission/role', 'admin/system/menu', 'admin/system/page'];
        if(!in_array($tag, $system_tags)) {
            $this->config = include base_path('config/columns/' . $tag . '.php');
        }else{
            $this->config = include base_path('vendor/zhyu/vue.crud/src/config/columns/' . $tag . '.php');
        }
        */
        $this->getConfig($tag);

        $rep = app($repository);
        if(isset($this->config['joins']) && count($this->config['joins'])){
            $qb = $rep->getModel();
            $this->table = $qb->getTable();
            $columns = $this->getTableColumns($this->table);
            $selects = [];

            $qb_subs = [];
            foreach($this->config['columns'] as $col => $column){
                if(!in_array($col, $columns)){
                    continue;
                }
                if(isset($column['relation'])) {
                    //$col = DB::raw($column['relation']['table'] . '.' . $column['relation']['column'] . ' as ' . $col);
                    $qb_sub = DB::table($column['relation']['table'])->select($column['relation']['column']);
                    if(count($column['relation']['wheres'])) {
                        foreach($column['relation']['wheres'] as $where) {
                            $qb_subs[$col] = call_user_func_array([$qb_sub, 'where'], $where);
                            if(isset($this->config['joins'][$col])){
//                                dump($this->config['joins'][$col]);
                                $qb_subs[$col] = call_user_func_array([$qb_sub, 'whereColumn'], $this->config['joins'][$col]);
                            }
                        }
                    }

//                    dump($qb_sub->toSql(), $column);
//                    dump('1111111111', $col, $column);
//                    $qb = $qb->selectSub($qb_sub, $col);
//                    dd($qb->toSql(), $column);
                }else{
                    $col = $this->table.'.'.$col;
                }
                if(count($selects)==0){
                    array_push($selects, $this->table.'.id');
                }
                array_push($selects, $col);

            }


            //foreach($this->config['joins'] as $col => $joins){
            //$qb = call_user_func_array([$qb, 'join'], $joins);
            //}

            $qb = $qb->select($selects);
//            dump($qb->toSql());
            if(count($qb_subs)){
                foreach($qb_subs as $col => $qb_sub){
                    $qb = $qb->selectSub($qb_sub, $col);
                }
            }
            //dd($qb->toSql());

        }else{
            $this->table = $rep->makeModel()->getTable();
            $qb = $rep->select(['*']);
        }

        return $qb;
    }


    /**
     * @param $qb
     * @return mixed
     */
    private function rowsOrderby($qb){
//        dump($qb->toSql());
        if($qb instanceof Repository){
            $qb = $qb->getModel();
        }
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
//        dd($qb->toSql());
//        dd($qb->toSql(), $qb->getBindings());
        $rows = $qb->paginate();

        return $rows;
    }

    /**
     * @param $qb
     * @param string|null $query
     */
    private function processQuery($qb, string $query = null){
        if(is_null($query)) return ;

        $querys = ZhyuTool::urlMakeQuery('#')->decode($query);
        foreach($querys as $column => $qs) {
            $qb->where($column, $qs['0'], $qs['1']);
        }
    }

}
