<?php


namespace ZhyuVueCurd\Service\Table\Column;


use Illuminate\Support\Facades\Route;

trait TraitColumn
{
    private function getModelName(){
        $model = $this->rule->getModel();
        $class = explode('\\', get_class($model));
        $class_name = array_pop($class);
        if(strlen($class_name) > 0){

            return strtolower($class_name);
        }
    }

    private function getAction(){
        $route = Route::current();
        $a = $route->parameters;
        $action = $route->getActionMethod();

        return $action;
    }
}
