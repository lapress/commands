<?php

namespace LaPress\Commands;

use Illuminate\Support\ServiceProvider;
use LaPress\Commands\Console\Commands\ThemeLinkCommand;

class CommandsServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->commands([
            ThemeLinkCommand::class
        ]);
    }
}
