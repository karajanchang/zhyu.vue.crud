<?php


namespace ZhyuVueCurd\Service;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

trait TraitCurlService
{
    public function findById(int $id){

        return $this->repository->find($id);
    }

    public function store(){
        $all = $this->getParams(false);
        if(method_exists($this->repository, 'insertByParams')){

            return $this->repository->insertByParams($all);
        }

        return $this->repository->insertGetId($all);
    }

    public function update(Model $model){
        $all = $this->getParams(true);
        if(method_exists($this->repository, 'updateByParams')){

            return $this->repository->updateByParams($model->id, $all);
        }

        return $this->repository->update($model->id, $all);
    }

    public function destroy(Model $model){
        if(method_exists($this->repository, 'deleteById')){

            return $this->repository->deleteById($model->id);
        }

        return $model->delete();
    }

    private function getParams(bool $is_update = false) : array{
        $all = $this->request->all();
        if(method_exists($this, 'processParams')){
            $all = $this->processParams($all, $is_update);
        }
        if(is_array($all)) {
            Log::info(__CLASS__ . '::' . __METHOD__ . ': ', $all);
        }

        return $all;
    }
}
