<?php


namespace ZhyuVueCurd\Commands;


use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;

class AdminCleanCacheCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'admin:cleanCache {--force}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '清除cache';

    public function handle()
    {
        $confirm_text = 'Are you sure to clean cache (Authoriztion ...)?';
        $force = $this->option('force');
        if ($force===true || $this->confirm($confirm_text)) {
            $key = env('ADMIN_AUTHORIZATION_CACHE_KEY', '_ZhyuAuth_::Permissions');
            Cache::forget($key);
            $this->info('Cache have been cleaned');
        }
    }

}
