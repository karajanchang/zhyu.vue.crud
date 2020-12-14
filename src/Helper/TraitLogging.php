<?php


namespace ZhyuVueCurd\Helper;


use Bugsnag\BugsnagLaravel\Facades\Bugsnag;
use Illuminate\Support\Facades\Log;

trait TraitLogging
{
    protected function logException(\Exception $e, bool $is_notify = true){
        if($is_notify===true) Bugsnag::notifyException($e);

        $msg = env('APP_DEBUG') === true ? $e->getMessage() : null;
        Log::error(__CLASS__ . '::' . __METHOD__ . ' error: ' . $msg, [$e]);

        return $msg;
    }
}
