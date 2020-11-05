<?php
/**
 * Created by PhpStorm.
 * User: david
 * Date: 2019-03-02
 * Time: 05:36
 */

namespace ZhyuVueCurd;

use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;


class ZhyuServiceProvider extends ServiceProvider
{
    protected $commands = [
    ];

    public function register(){
        $this->loadFunctions();

        /*
        $this->app->bind('ZhyuGate', function()
        {
            return app()->make(\Zhyu\Helpers\ZhyuGate::class);
        });
        */

        $this->registerAliases();
    }

    public function boot(){
        if ($this->isLumen()) {
            require_once 'Lumen.php';
        }

        if ($this->app->runningInConsole()) {
            $this->commands($this->commands);
        }
    }

    protected function loadFunctions(){
        foreach (glob(__DIR__.'/functions/*.php') as $filename) {
            require_once $filename;
        }
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [
            Zhyu\ZhyuServiceProvider::class,
        ];
    }

    /**
     * Register aliases.
     *
     * @return null
     */
    protected function registerAliases()
    {
        if (class_exists('Illuminate\Foundation\AliasLoader')) {
            $loader = \Illuminate\Foundation\AliasLoader::getInstance();

//            $loader->alias('ZhyuCurl', \Zhyu\Facades\ZhyuCurl::class);
        }
    }

    protected function isLumen()
    {
        return str_contains($this->app->version(), 'Lumen');
    }
}
