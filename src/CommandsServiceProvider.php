<?php

namespace LaPress\Commands;

use Illuminate\Support\ServiceProvider;
use LaPress\Commands\Console\Commands;

/**
 * @author Sebastian Szczepański
 * @copyright Ably
 */
class CommandsServiceProvider extends ServiceProvider
{

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->commands([
            Commands\ThemeLinkCommand::class,
            Commands\MakeThemeCommand::class,
            Commands\InstallCommand::class,
            Commands\LinkContentCommand::class,
            Commands\InitWordpressConfigCommand::class,
            Commands\SearchImportCommand::class,
        ]);
    }
}
