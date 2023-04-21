<?php


namespace ZhyuVueCurd\Service;


use BinaryCabin\LaravelUUID\Traits\HasUUID;
use Carbon\Carbon;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

trait TraitCrulService
{
    use HasUUID;

    public function findById(int $id){

        return $this->repository->find($id);
    }

    /*
     * 處理date 和 datetime
     */
    private function processAllColumn(Model $model, array &$all){
        $columns = Schema::getConnection()->getDoctrineSchemaManager()->listTableColumns($model->getTable());
        Log::info('columns', $columns);
        if(isset($columns['uuid'])){
            $all['uuid'] = null;
        }
        foreach($columns as $name => $column){
            if(isset($all[$name])) {
                if ($column->getType() instanceof \Doctrine\DBAL\Types\DateType) {
                    $dt = new Carbon($all[$name]);
                    $all[$name] = $dt->format('Y-m-d');
                }
                if ($column->getType() instanceof \Doctrine\DBAL\Types\DateTimeType) {
                    $dt = new Carbon($all[$name]);
                    $all[$name] = $dt->format('Y-m-d H:i:s');
                }
                if ($column->getType() instanceof \Doctrine\DBAL\Types\BooleanType) {
                    $all[$name] = $all[$name] ?? false;
                }
            }
        }

        Log::info('processAllColumn: ', [$all]);

        return $all;
    }

    private function processUUID($all){
        if(key_exists('uuid', $all) && empty($all['uuid'])){
            unset($all['uuid']);
        }
    }
    public function store(){
        $all = $this->getParams(false);
        $this->processAllColumn(app(app($this->repository())->model()), $all);

        $this->processUUID($all);

        if(method_exists($this->repository, 'insertByParams')){

            return $this->repository->insertByParams($all);
        }

        return $this->repository->insertGetId($all);
    }

    public function update(Model $model){
        $all = $this->getParams(true);
        $this->processAllColumn($model, $all);

        $this->processUUID($all);

        if(method_exists($this->repository, 'updateByParams')){

            return $this->repository->updateByParams($model->id, $all);
        }
        $res = $this->repository->update($model->id, $all);
        return $res;
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
