<?php


namespace ZhyuVueCurd\Http\Controllers;


use Illuminate\Database\Eloquent\Model;

trait CRULTrait
{
    private function rules_store(){
        $rules = $this->tableService->rulesCombined();

        return $rules;
    }

    private function rules_update(Model $model){

        return $this->tableService->rulesCombined($model);
    }

}
