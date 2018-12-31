<?php

namespace LaPress\Commands\Console\Commands;

use Illuminate\Console\Command;
use LaPress\Commands\Services\Theme;

class MakeThemeCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'lapress:make:theme {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create lapress theme';
    /**
     * @var Theme
     */
    private $theme;

    /**
     * Create a new command instance.
     *
     * @param Theme $theme
     */
    public function __construct(Theme $theme)
    {
        $this->theme = $theme;

        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $name = $this->argument('name');

        $this->theme->create($name, __DIR__.'/stubs');
        try {
            $this->theme->link($name);
        } catch (\Exception $e) {

        }
        try {
            $this->theme->linkPublic($name);
        } catch (\Exception $e) {

        }
        $this->line('Theme "'.$name.'" generated.');
        $this->line('Add "APP_THEME='.$name.'" to your .env file to use it');
    }
}
