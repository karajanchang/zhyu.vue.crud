<?php


namespace ZhyuVueCurd\Commands;

use Illuminate\Support\Facades\Artisan;
use InvalidArgumentException;
use Illuminate\Console\GeneratorCommand;
use Symfony\Component\Console\Exception\InvalidOptionException;

class MakeServiceCommand extends GeneratorCommand
{
    /**
     * The name of the module.
     *
     * @var string
     */
    private $moduleName = null;

    /**
     * The name of the tag.
     *
     * @var string
     */
    private $tagName = null;


    /**
     * The name of the Repository.
     *
     * @var string
     */
    private $repositoryName = '';

    /**
     * The real name of the Repository.
     *
     * @var string
     */
    private $onlyRepositoryName = '';

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'zhyu:vue:service {name} {--r=} {--with-tag} {--tag=} {--module=} {--all} {--title=}';

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'zhyu:vue:service';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new service class';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Service';

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        return __DIR__.'/stubs/service.stub';
    }

    /**
     * Get the default namespace for the class.
     *
     * @param  string  $rootNamespace
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace)
    {
        $namespace = $rootNamespace.'\Service';

        if(!is_null($this->moduleName)){
            $namespace.='\\'.$this->moduleName;
        }

        if(!is_null($this->tagName)){

            $namespace.='\\'.$this->tagName;
        }

        return $namespace;
    }

    public function handle()
    {
        if(!$this->argument('name')){
            throw new InvalidArgumentException("Missing required argument of service name");
        }

        if(!$this->option('r')){
            $this->info('Please enter --r= for repository name');

            return ;
        }

        //---要一併建立其他controller和coloums描述時
        if($this->option('all')===true){
            if(!$this->option('title')) {
                $this->info('Please enter --title= for title of table');

                return ;
            }
        }



        $tag = (string) $this->option('tag');
        if(strlen($tag)>0) {
            $this->tagName = ucwords($tag);
        }
        $this->onlyRepositoryName = $this->option('r');
        if(!is_null($this->tagName) && $this->option('with-tag')===true){
            $this->repositoryName = $this->tagName.'\\'.ucwords($this->option('r'));
        }else{
            $this->repositoryName = ucwords($this->option('r'));
        }

        $module = (string) $this->option('module');
        if(strlen($module)){
            $this->moduleName = ucwords($module);
        }


        parent::handle();

        //---下 --all時也順便製作controller
        if($this->option('all')===true) {
            $this->call('zhyu:vue:controller', $this->makeControllerParams());
            $this->call('zhyu:vue:columns', $this->makeColumnsParams());
        }
    }


    /**
     * Replace the Model name for the given stub.
     *
     * @param  string  $stub
     * @param  string  $name
     * @return string
     */
    protected function replaceClass($stub, $name)
    {


        $stub = parent::replaceClass($stub, $name);
        $repository = '';
        if(!is_null($this->moduleName)){
            $repository .= $this->moduleName.'\\';
        }
        if(!is_null($this->tagName)){
            $repository .= $this->tagName.'\\';
        }
        $repository .= $this->repositoryName;
        $stub = str_replace('DummyRepository', $repository, $stub);

        return str_replace('DummyOnlyRepository', $this->onlyRepositoryName, $stub);

    }

    private function makeControllerParams(){

        return [
            'name' => str_replace('Service', 'Controller', $this->argument('name')),
            '--s' => $this->argument('name'),
            '--with-tag' => !is_null($this->tagName) ?  true : false,
            '--tag' => $this->tagName,
            '--module' => $this->moduleName,
        ];

    }

    private function makeColumnsParams(){
        $namespace = '\App\Service';

        if(!is_null($this->moduleName)){
            $namespace.='\\'.$this->moduleName;
        }
        if(!is_null($this->tagName)){
            $namespace.='\\'.$this->tagName;
        }
        $service = $namespace.'\\'.$this->argument('name');
        try {
            $modelName = app(app(app($service)->repository())->model())->getTable();
        }catch (\Exception $e){
            throw new InvalidArgumentException("can not get the name of model");
        }

        return [
            'name' => strtolower(str_replace('Service', '', $this->argument('name'))),
            '--model' => $modelName,
            '--module' => $this->moduleName,
            '--tag' => $this->tagName,
        ];

    }
}

//--php artisan zhyu:vue:service NewsService --r=NewsRepository --with-tag --tag=news
//--with-tag 是指NewsRepository要不要在tag的目錄內，不是指 server 本身
//--all 參數是順便製作 NewsController
//php artisan zhyu:vue:service NewsService --r=NewsRepository  --module=admin --tag=news --all --title=最新消息

