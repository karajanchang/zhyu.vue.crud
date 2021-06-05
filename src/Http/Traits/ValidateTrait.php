<?php
namespace ZhyuVueCurd\Http\Traits;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\MessageBag;

Trait ValidateTrait
{
    /**
     * 拿到request和裝置的參數，並把二者合起來
     * @return array
     */
    public function getParams(){
        $request = app(Request::class);
        $params = (array) $request->input("params");
        $attributes = $request->input("attributes");
        $pars = $params;

        if(is_array($attributes)) {
            $pars = array_merge($params, $attributes);
        }
        return $pars;
    }

    /**
     * 驗證
     * @param array $rules
     * @param null $request
     * @return array|bool|\Exception
     */
    public function valid(array $rules, $request = null){
        if(count($rules)==0) return true;

        if(is_array($request)){
            $pars = $request;
        }else{
            $pars = $this->getParams();
        }
        if(!is_array($pars)) return new \Exception('Validate params is not array');

        $validate = Validator::make($pars, $rules);
        // dd($validate->fails());
        if($validate->fails()){
            $msgs = $validate->messages();

            return $this->validError($msgs);
        }

        return true;
    }

    /**
     * 輸出101驗證錯誤
     * @param $msgs
     * @return array
     */
    private function validError($msgs){

        return [
            'code' => 0,
            'msg' => trans('ZhyuVueCurd::errors.validate_error'),
            'return' => null,
            'error' => [
                'code' => '101',
                'message' => $this->parseValidateMessage($msgs),
            ],
        ];
    }

    /**
     * 若是MessageBag的則抓取第一個
     * @param $msgs
     * @return string
     */
    private function parseValidateMessage($msgs){
        if($msgs instanceof MessageBag && env('STRIP_VALIDATE_MESSAGE', false)===true){

            return $msgs->first();
        }else{

            return $msgs;
        }
    }
}
