<?php


namespace ZhyuVueCurd\Service;


use Illuminate\Http\Request;

abstract class AbstractCurlService
{
    /**
     * @var Repository
     */
    protected $repository;

    /**
     * @var Request
     */
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
        $this->repository = app($this->repository());
    }

    abstract protected function repository();
}
