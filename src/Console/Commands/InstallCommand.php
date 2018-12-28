<?php

namespace LaPress\Commands\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;

class InstallCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'lapress:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install laPress';
    /**
     * @var Filesystem
     */
    private $filesystem;

    /**
     * Create a new command instance.
     *
     * @param Filesystem $filesystem
     */
    public function __construct(Filesystem $filesystem)
    {
        $this->filesystem = $filesystem;
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $path = base_path('wordpress');
        if ($this->filesystem->exists($path)) {
            $this->filesystem->deleteDirectory($path);
        }

        \Artisan::call('preset', ['type' => 'lapress']);
        exec('composer update johnpbloch/wordpress-core');
        \Artisan::call('lapress:uploads:link');

        $this->filesystem->cleanDirectory(
            wordpress_path('wp-content/themes')
        );

        \Artisan::call('lapress:install:wp-config');

        $this->line('');
        $this->info('----------------------------');
        $this->info('|    laPress installed.    |');
        $this->info('----------------------------');
        $this->line('');
        $this->line('Creating new theme');

        $theme = $this->ask('Type theme name');

        \Artisan::call('lapress:make:theme', ['name' => $theme]);
        $this->line('Theme "'.$theme.'" generated.');
        $this->line('Add "APP_THEME='.$theme.'" to your .env file to use it');
    }
}
