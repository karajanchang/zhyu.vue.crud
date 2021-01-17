<?php


namespace ZhyuVueCurd\Service\Table\Column;


class ColumnService
{
    public function __construct(InterfaceColumn $column)
    {
        $this->column = $column;
    }

    public function model($model){
        $this->column->model = $model;

        return $this;
    }

    public function name($name){
        $this->column->name = $name;

        return $this;
    }

    public function field($field){
        $this->column->field = $field;

        return $this;
    }

    public function rule($rule = null){
        $this->column->rule = $rule;

        return $this;
    }

    public function relation($relation){
        $this->column->relation = $relation;

        return $this;
    }

    public function values($values = null){
        $this->column->values = $values;

        return $this;
    }

    public function rulesOnlyBackend(bool $rules_only_backend = null){
        $this->column->rules_only_backend = $rules_only_backend;

        return $this;
    }


    public function __toString()
    {
        return (string) $this->column;
    }

}
