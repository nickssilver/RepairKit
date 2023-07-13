<?php

namespace App\Providers;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ComposerViewServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {

        if (File::exists(storage_path('installed')) && File::exists(base_path('/.env'))) {
            View::composer(['*'], \App\Http\View\Composers\AppComposer::class);
        }
    }
}
