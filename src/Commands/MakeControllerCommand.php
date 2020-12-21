<?php


namespace ZhyuVueCurd\Commands;

use InvalidArgumentException;
use Illuminate\Console\GeneratorCommand;
use Symfony\Component\Console\Exception\InvalidOptionException;

class MakeControllerCommand extends GeneratorCommand
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
    private $serviceName = '';

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'zhyu:vue:controller {name} {--s=} {--with-tag} {--tag=} {--module=}';

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'zhyu:vue:controller';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new controller class';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Controller';

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        return __DIR__.'/stubs/controller.stub';
    }

    /**
     * Get the default namespace for the class.
     *
     * @param  string  $rootNamespace
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace)
    {
        $namespace = $rootNamespace.'\Http\Controllers';

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

        if(!$this->option('s')){
            throw new InvalidOptionException('Missing required option --s for service name');
        }


        $module = (string) $this->option('module');
        if(strlen($module)>0){
            $this->moduleName = ucwords($module);
        }

        $tag = (string) $this->option('tag');
        if(strlen($tag)>0) {
            $this->tagName = ucwords($tag);
        }


        if(!is_null($this->moduleName)) {
            $this->serviceName = $this->moduleName.'\\';
        }
        if(!is_null($this->tagName) && $this->option('with-tag')===true){
            $this->serviceName .= $this->tagName.'\\';
        }
        $this->serviceName .= ucwords($this->option('s'));

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


        $stub = parent::replaceClass($stub, $name);

        $stub = str_replace('DummyModule', strtolower($this->moduleName), $stub);

        $dummyTag = '';
        if(!is_null($this->tagName)) {
            $dummyTag .= strtolower($this->tagName).'.';
        }
        $dummyTag .= strtolower(str_replace('Controller', '', $this->argument('name')));
        $stub = str_replace('DummyTag', $dummyTag, $stub);

        $stub = str_replace('DummyService', $this->serviceName, $stub);

        return str_replace('DummyMapService', ucwords($this->option('s')), $stub);
    }

}
//php artisan zhyu:vue:controller NewsController --s=NewsService --with-tag --module=admin --tag=news
//php artisan zhyu:vue:controller NewsController --s=NewsService --module=admin
