<?php


namespace ZhyuVueCurd\Commands;

use InvalidArgumentException;
use Illuminate\Console\GeneratorCommand;
use Symfony\Component\Console\Exception\InvalidOptionException;

class MakeColumnsCommand extends GeneratorCommand
{
    /**
     * The title.
     *
     * @var string
     */
    private $titleName = '';

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
    private $modelName = null;

    /**
     * The url.
     *
     * @var string
     */
    private $urlName = null;


    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'zhyu:vue:columns {name} {--title=} {--module=} {--tag=} {--model=} {--url=}';

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'zhyu:vue:columns';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new coloum array in /config/columns';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Columns';

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        return __DIR__.'/stubs/columns.stub';
    }

    /**
     * Get the default namespace for the class.
     *
     * @param  string  $rootNamespace
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace)
    {
        $namespace = 'config\columns';

        return $namespace;
    }

    public function handle()
    {
        $dir = base_path('config/columns');
        if(!file_exists($dir)){
            mkdir($dir);
        }

        $title = (string) $this->option('title');
        if(strlen($title)>0) {
            $this->titleName = $title;
        }

        $url = '/';
        $module = (string) $this->option('module');
        if(strlen($module)>0) {
            $this->moduleName = strtolower($module);
            $url .= $this->moduleName.'/';
        }

        $tag = (string) $this->option('tag');
        if(strlen($tag)>0) {
            $this->tagName = strtolower($tag);
            $url .= $this->tagName.'/';
        }
        $model = (string) $this->option('model');
        if(strlen($model)==0) {
            $this->info('Please enter --model=');

            return ;
        }
        $this->modelName = ucfirst($model);
        $url .= strtolower($this->modelName);
        $this->urlName = $url;

        $this->dectectModel();
        $this->replaceStub();
    }

    private function dectectModel(){
        $names = [
            '\App\Models\\'.$this->modelName,
            '\App\\'.$this->modelName,
        ];
        foreach($names as $name) {
            if (class_exists($name)) {
                $this->modelName = $name;

                break;
            }
        }
    }

    private function replaceStub(){
        $stub = file_get_contents($this->getStub());
        $stub = str_replace('DummyModel', $this->modelName, $stub);
        $stub = str_replace('DummyTitle', $this->titleName, $stub);
        $stub = str_replace('DummyUrl', $this->urlName, $stub);

        $this->writeStub($stub);
    }

    private function getDir(){
        $dir = 'config/columns';
        if(!is_null($this->moduleName)){
            $dir .= '/' . $this->moduleName;
            if(!file_exists($dir)){
                mkdir($dir);
            }
        }
        if(!is_null($this->tagName)){
            $dir .= '/' . $this->tagName;
            if(!file_exists($dir)){
                mkdir($dir);
            }
        }

        return base_path($dir);
    }

    private function writeStub($stub){
        $dir = $this->getDir();

        $file = $dir . '/' .strtolower($this->argument('name')).'.php';
        file_put_contents($file, $stub);
    }
}
//php artisan zhyu:vue:columns news --model=news --module=admin --tag=abc --title=今天

