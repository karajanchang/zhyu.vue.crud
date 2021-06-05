<?php


namespace ZhyuVueCurd\Http\Traits;


use Illuminate\Support\Facades\Lang;
use ZhyuVueCurd\Errors\ErrorAbstract;

trait ControllerOutputTrait
{

    /**
     * 正式站錯誤Response
     *
     * @return void
     */
    public function productionError()
    {
        return $this->output([]);
    }

    /**
     * 輸出錯誤response
     * @param null $msg
     * @param null $obj
     * @param int $code
     * @return array
     */
    public function error($error = null, $code = 0)
    {
        return $this->output([
            'code' => $code,
            'error' => $error,
        ]);
    }

    public function validError($validMessage)
    {
        return $this->output([
            'code' => 101,
            'msg' => null,
            'obj' => null,
            'valid' => $validMessage,
            'errorMessage' => 'HTTP驗證錯誤'
        ]);
    }

    /**
     * 輸出成功response
     * @param null $msg
     * @param null $obj
     * @return array
     */
    public function success($msg = null, $obj = null)
    {
        return $this->output([
            'code' => 1,
            'msg' => $msg,
            'obj' => $obj
        ]);
    }

    /**
     * 將 code 轉換成 response code
     *
     * @param  mixed $code
     * @return void
     */
    public function covertCodeToResponseCode(int $code = 1)
    {
        switch ($code) {
            case 0:
            case 500:
                return 500;
            case 101:
                return 422;
            default:
                return 200;
        }
    }

    public function output(array $paramters)
    {
        $tmp = [
            'code' => $paramters['code'] ?? 0,
            'msg' => $paramters['msg'] ?? null,
            'return' => $paramters['obj'] ?? new \stdClass(),
            'error' => new \stdClass(),
            'validate' => $paramters['valid'] ?? new \stdClass()
            // 'validate' => $paramters['valid'] ?? []
        ];

        // 當$msg未設定時 根據$code來設定$msg為預設值
        if (!isset($tmp['msg'])) {
            $tmp['msg'] = $tmp['code'] == 1 ? Lang::get('universal.response.msg.success') : Lang::get('universal.response.msg.error');
        }

        if (empty($tmp['validate'])) {
            $tmp['error'] = [
                'code' => $tmp['code'],
                //TODO : unit 可能還要定義或不需要?
                'unit' => 'driver',
                'message' => $paramters['errorMessage'] ?? 'HTTP驗證錯誤'
            ];
        }

        if (isset($paramters['error'])) {
            $tmp['msg'] = $paramters['error']->getMessage();
            $tmp['error'] = [
                'code' => $tmp['code'],
                //TODO : unit 可能還要定義或不需要?
                'unit' => 'driver',
                'message' => $paramters['error']->getTraceAsString() ?? 'Some錯誤'
            ];
        }

        $responseCode = $this->covertCodeToResponseCode($tmp['code']);

        return response()->json($tmp, $responseCode);
    }

    /**
     * 實際的response
     * @param null $code
     * @param null $msg
     * @param null $obj
     * @param array $valid
     * @return array
     */
    public function outputBK($code = null, $msg = null, $obj = null, $valid = [])
    {
        if (is_null($code)) {
            $code = 1;
        }

        $pre = $code == 1 ?   Lang::get('messages.success')   :   Lang::get('messages.error');

        $rObj = new \stdClass();
        $rObj->code = $code;
        $rObj->msg = $pre;
        $rObj->return = null;

        if (is_string($msg)) {
            $msg = is_null($msg) ?  $pre :   Lang::get($msg);
            $rObj->msg = $msg;
            $rObj->validate = $valid;
        } elseif (is_array($msg)) {
            if (isset($msg['error'])) {
                $errorObj = $msg['error'];
                if (is_array($errorObj)) {

                    return $msg;
                }
                $rObj->msg = $errorObj->getMessage();
                //$error = new \stdClass();
                $error = [];
                $error['code'] = (string) $errorObj->getCode();
                $error['unit'] = (string) $errorObj->getUnit();
                $error['message'] = $errorObj->getMessage();

                $rObj->error = $error;
            }
            if (isset($msg['msg'])) {
                $valid = $msg['msg'];
                $rObj->validate = $valid;
            }
        }
        if (!is_null($obj)) {
            $rObj->return = $obj;
        }

        return response()->json($rObj);
    }
}
