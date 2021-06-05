<?php
/**
 * Created by PhpStorm.
 * User: david
 * Date: 2019-05-09
 * Time: 12:24
 */

namespace ZhyuVueCurd\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;
use ZhyuVueCurd\Http\Traits\ValidateTrait;
use Validator;

abstract class ServiceAbstract
{
    use ValidateTrait;

    protected $repository;
    protected $error;
    protected $params = [];
    protected $attrs = [];

    public function __construct(){
        $this->repository = app($this->repository());
        $this->error = app($this->error());
    }

    /**
     * 設定repository
     * @return string
     */
    abstract public function repository();

    /**
     * 設定error
     * @return string`
     */
    abstract public function error();

    /**
     * 得到
     * @param $rules
     * @return array
     */
    private function messages($rules){
        $trans = $this->getLanguage();

        $attributes = $this->error->getAttributes();

        $msgs = [];
        foreach($rules as $rule => $contains){
            if(isset($attributes[$rule])){
                if(strstr($contains,'|')){
                    $items = explode('|', $contains);
                }else{
                    $items[] = $contains;
                }
                foreach($items as $item){
                    $item = trim($item);
                    if($item=='nullable') continue;

                    if(strstr($item, ':')){
                        $exs = explode(':', $item);
                        $item = $exs[0];
                    }

                    $tmp = $rule.'.'.$item;
                    $msgs[$tmp] = str_replace(':attribute', $attributes[$rule], $trans[$item]);
                }
            }
        }

        return $msgs;
    }

    /**
     * @return array
     */
    private function getLanguage(){
        $locale = Config::get('app.locale');

        $files = [
            base_path('resources/lang/'.$locale.'/validation.php'),
            base_path('vendor/zhyu/vue.crud/packages/src/lang/'.$locale.'/validation.php')
        ];

        foreach($files as $file){
           if(file_exists($file)){

               return include $file;
           }
        }

        return [];
    }

    /**
     * 驗證，會直接讀取Server本身的function rules()
     * @param array $params
     * @return array|bool
     */
    public function validate(array $params){
        $rules = $this->rules();
        $messages = $this->messages($rules);
        $validator = Validator::make($params, $rules, $messages);

        if($validator->fails()){
            $msg = $validator->messages();

            return [
                'error' =>  $this->error['101'],
                'msg' => $msg,
            ];
        }

        return true;
    }

    /**
     * 驗證，可以不輸入params，直接去抓request的參數
     * @param array $params
     * @return array|bool
     */
    public function validateParams(array $params = []){
        if(count($params)==0) {
            $request = app()->make(Request::class);
            $this->params = $request->input("params");
        }else{
            $this->params = $params;
        }

        if(!isset($this->params) || count($this->params)==0){

            abort(400, '沒有參數');
        }

        $res = $this->validate($this->params);

        return $res;
    }

    /**
     * 驗證有沒有傳回android或IOS APP的裝置參數，若沒有回傳400 error
     * @return null
     */
    public function validateAttribures(){
        $request = app()->make(Request::class);
        $this->attrs = $request->input("attributes");
        if(!isset($this->attrs) || count($this->attrs)==0){

            abort(400, '沒有裝置參數');
        }
    }

    /**
     * 同時驗證裝置參數和request參數
     * @param array $params
     * @return array|bool
     */
    public function validateAttributesAndParams(array $params = []){
        $this->validateAttribures();

        return $this->validateParams($params);
    }

    /**
     * @param string $key
     * @return bool
     */
    public function hasCache(string $key){

        return Cache::has($key);
    }

    /**
     * @param string $key
     * @return mixed
     */
    public function fromCache(string $key){

        return Cache::get($key);
    }

    /**
     * Alias of fromCache
     * @param string $key
     * @return mixed
     */
    public function getCache(string $key){

        return $this->fromCache($key);
    }

    /**
     * @param string $key
     * @param $data
     * @param null $seconds
     * @return bool
     */
    public function putCache(string $key, $data, $seconds = null){
        if(is_null($seconds)){
           $seconds = env('CACHE_DEFAULT_EXPIRED_SECONDS', 300);
        }

        return Cache::put($key, $data, $seconds);
    }
}
