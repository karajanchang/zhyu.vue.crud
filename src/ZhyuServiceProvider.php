<?php
/**
 * Created by PhpStorm.
 * User: david
 * Date: 2019-03-02
 * Time: 05:36
 */

namespace ZhyuVueCurd;

use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;
use ZhyuVueCurd\Commands\MakeColumnsCommand;
use ZhyuVueCurd\Commands\MakeControllerCommand;
use ZhyuVueCurd\Commands\MakeServiceCommand;
use ZhyuVueCurd\Helper\ConfigsHelper;
use ZhyuVueCurd\Http\Livewire\Admin\ConfigForm;
use ZhyuVueCurd\Http\Livewire\Admin\ConfigList;
use ZhyuVueCurd\Http\Livewire\Admin\ConfigNameValue;
use ZhyuVueCurd\Http\Livewire\Admin\ConfigSetValue;
use ZhyuVueCurd\Http\Livewire\Admin\LeftMenu;
use ZhyuVueCurd\Http\Livewire\Admin\MenuBreadcrumb;
use ZhyuVueCurd\Http\Livewire\Admin\TableIndex;
use ZhyuVueCurd\Http\Livewire\Admin\TableRowDrag;


class ZhyuServiceProvider extends ServiceProvider
{
    protected $commands = [
        MakeControllerCommand::class,
        MakeColumnsCommand::class,
        MakeServiceCommand::class,
    ];

    public function register(){
        $this->loadFunctions();

        /*
        $this->app->bind('ZhyuGate', function()
        {
            return app()->make(\Zhyu\Helpers\ZhyuGate::class);
        });
        */
        $this->app->bind('Configs',function() {

            return new ConfigsHelper();
        });

        $this->registerAliases();
    }

    public function boot(){
        $this->loadViewsFrom(__DIR__.'/views', 'ZhyuVueCurd');
        if ($this->isLumen()) {
            require_once 'Lumen.php';
        }

        if ($this->app->runningInConsole()) {
            $this->commands($this->commands);
        }

        /*
         * 註冊 livewire compnnents
         */
        Livewire::component('admin.config-form', ConfigForm::class);
        Livewire::component('admin.config-list', ConfigList::class);
        Livewire::component('admin.config-name-value', ConfigNameValue::class);
        Livewire::component('admin.config-set-value', ConfigSetValue::class);
        Livewire::component('admin.left-menu', LeftMenu::class);
        Livewire::component('admin.menu-breadcrumb', MenuBreadcrumb::class);
        Livewire::component('admin.table-index', TableIndex::class);
        Livewire::component('admin.table-row-drag', TableRowDrag::class);
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
            ZhyuServiceProvider::class,
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

            $loader->alias('Configs', \ZhyuVueCurd\Facades\ConfigsFacades::class);
        }
    }

    protected function isLumen()
    {
        return str_contains($this->app->version(), 'Lumen');
    }
}
