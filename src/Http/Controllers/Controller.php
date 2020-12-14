<?php

namespace ZhyuVueCurd\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function capName(string $name) : string{
        if(strstr($name, '-')) {
            $names = explode('-', $name);
        }elseif(strstr($name, '_')) {
            $names = explode('_', $name);
        }else{

            return ucfirst($name);
        }

        $caps = array_map(function($name){
            return ucfirst($name);
        }, $names);

        return join('', $caps);
    }
}
