<?php


namespace ZhyuVueCurd\Commands;

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
     * The name of the model.
     *
     * @var string
     */
    private $repositoryName = '';

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'zhyu:vue:service {name} {--r=} {--with-tag} {--tag=} {--module=}';

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
        if(!$this->option('r')){
            throw new InvalidOptionException('Missing required option --r for repository name');
        }


        $tag = (string) $this->option('tag');
        if(strlen($tag)>0) {
            $this->tagName = ucwords($tag);
        }

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
        if(!$this->argument('name')){
            throw new InvalidArgumentException("Missing required argument of service name");
        }

        $stub = parent::replaceClass($stub, $name);

        return str_replace('DummyRepository', $this->repositoryName, $stub);
    }

}
