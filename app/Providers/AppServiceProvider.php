<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        ini_set("memory_limit", "1000M");
        ini_set('post_max_size', '1000M');
        ini_set('upload_max_filesize', '1000M');
        ini_set('max_execution_time', '1000');
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
