<?php

//--看是否符合url  (把第一個 /admin/system  ==> admin/system*)
function ifMatchUrl($url){
    $url = preg_replace('/^\//', '', $url);
    if(\Request::is($url.'*')){
        return true;
    }
    return false;
}

function configs(string $tag, int $timeout = null)
{
    return Configs::get($tag, $timeout);
}
