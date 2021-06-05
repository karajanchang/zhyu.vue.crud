<?php
/**
 * Created by PhpStorm.
 * User: david
 * Date: 2019-05-07
 * Time: 19:03
 */

namespace ZhyuVueCurd\Errors;

use Error;
use ArrayAccess;
use Exception;
use Illuminate\Support\Facades\Log;
use Throwable;
use Illuminate\Support\Facades\Config;

class ErrorAbstract extends Error implements ArrayAccess
{
    protected $code = null;
    protected $message = null;
    protected $unit = null;
    protected $attributes;
    protected $replaces = [];

    /**
     * ErrorAbstract constructor.
     * @param string $message
     * @param int $code
     * @param Throwable|null $previous
     * @throws Exception
     */
    public function __construct(string $message = "", int $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);

        $lang_path = $this->getLangPath();
        

        $lang = include $lang_path;
        
        $this->setAttributes($lang['attributes']);
    }

    /**
     * @return mixed
     * @throws Exception
     */
    private function getLangPath(){
        $locale = Config::get('app.locale');

        $error_dirs = [];
        $lang_path = base_path('resources/lang/' . $locale . '/' . $this->unit . '/validation.php');
        if (file_exists($lang_path)) {

            return $lang_path;
        }
        array_push($error_dirs, $lang_path);

        $lang_path = base_path('vendor/zhyu/vue.crud/packages/src/lang/' . $locale . '/' . $this->unit . '/validation.php');
        if (file_exists($lang_path)) {

            return $lang_path;
        }
        array_push($error_dirs, $lang_path);

        throw new Exception('can not find validation.php in lang directorys: '.join(',', $error_dirs));
    }

    /**
     * @return mixed
     */
    public function error101(){

        return trans('ZhyuVueCurd::errors.validate_error');
    }

    /**
     * @param $attributes
     */
    public function setAttributes($attributes){
        $this->attributes = $attributes;
    }

    /**
     * @return mixed
     */
    public function getAttributes(){
        return $this->attributes;
    }

    /**
     * @param $offset
     * @return string
     */
    private function name($offset){

        return 'error'.$offset;
    }

    /**
     * @param mixed $offset
     * @return bool
     */
    public function offsetExists($offset){
        if(method_exists($this, $this->name($offset))){

            return true;
        }

        return false;
    }

    /**
     * @param mixed $offset
     * @return $this|mixed
     */
    public function offsetGet($offset){
        $tmp = $this->name($offset);
        $this->code = $offset;
        $this->message = $this->$tmp();

        return $this;
    }

    /**
     * @param mixed $offset
     * @param mixed $value
     * @return $this|void
     */
    public function offsetSet($offset, $value){
        $this->code = $offset;
        $this->message = $value;

        return $this;
    }

    /**
     * @param mixed $offset
     */
    public function offsetUnset($offset){
        unset($this->code);
        unset($this->message);

        return $this;
    }

    /**
     * @return ErrorAbstract
     */
    public function getUnit()
    {
        return $this->unit;
    }

    /**
     * @param $tag
     * @param null $value
     * @return $this
     */
    public function setReplaces($tag ,$value = null){
        if(is_array($tag)){
            $this->replaces = $tag;
        }else {
            $this->replaces[$tag] = $value;
        }

        return $this;
    }

    /**
     * @return array
     */
    public function getReplaces($tag = null)
    {
        if(!is_null($tag)){
            $res = [];
            $res[$tag] = $this->replaces[$tag];

            return $res;
        }

        return $this->replaces;
    }

    /**
     * @return mixed
     */
    public function error500(){

        return trans('ZhyuVueCurd::errors.operation_error');
    }

    /**
     * @return mixed
     */
    public function error400(){

        $replaces = $this->getReplaces('400');
        return trans('ZhyuVueCurd::errors.not_allow_request', $replaces['400']);
    }

    /**
     * @param null $code
     * @param array $params
     * @return array
     */
    public function output($code = null, array $params = []){
        if(count($params)){
            $this->setReplaces($code, $params);
        }

        $res = [];

        if(!empty($this->unit)) {
            Log::info('ErrorAbstract unit: ' . $this->unit . ', code: ' . (string)$code . ', params: ', $params);
            $res['error'] = $this[$code];
        }else{
            $res['error'] = $this['500'];
        }

        return $res;
    }

    /**
     * @param $name
     * @param array $arguments
     * @return false|mixed
     */
    public function __call($name, array $arguments){


        return call_user_func_array([$this, 'output'], $arguments);
    }


}
