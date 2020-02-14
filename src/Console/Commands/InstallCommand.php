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
        $this->info('                                   ');
        $this->info('  _       ____                     ');
        $this->info(' | | __ _|  _ \ _ __ ___  ___ ___  ');
        $this->info(' | |/ _` | |_) | \'__/ _ \/ __/ __| ');
        $this->info(' | | (_| |  __/| | |  __/\__ \__ \ ');
        $this->info(' |_|\__,_|_|   |_|  \___||___/___/ ');
        $this->info('                                   ');


        $path = base_path('wordpress');
        if ($this->filesystem->exists($path)) {
            $this->filesystem->deleteDirectory($path);
        }

        \Artisan::call('preset', ['type' => 'lapress']);

        $wordpress = config('wordpress.core');
        if (!$this->filesystem->exists($wordpress)) {
            exec('composer update johnpbloch/wordpress-core');
        }
        // make themes directory
        $this->filesystem->makeDirectory(
            storage_path('content/themes')
        );
        // make uploads directory
        $this->filesystem->makeDirectory(
            storage_path('content/uploads')
        );
        // copy plugins directory with its content
        $this->filesystem->copy(
            wordpress_path('wp-content/plugins'),
            storage_path('content/plugins')
        );
        // copy languages directory with its content
        $this->filesystem->copy(
            wordpress_path('wp-content/languages'),
            storage_path('content/languages')
        );

        $this->filesystem->cleanDirectory(
            wordpress_path('wp-content')
        );

        exec('npm install');


        \Artisan::call('lapress:install:wp-config');
        \Artisan::call('lapress:content:link');

        $this->line('');
        $this->info('----------------------------');
        $this->info('|    laPress installed.    |');
        $this->info('----------------------------');
        $this->line('');
        $this->line('Creating new theme');

        $theme = $this->ask('Type theme name', basename(base_path()));

        \Artisan::call('lapress:make:theme', ['name' => $theme]);
        $this->line('Theme "'.$theme.'" generated.');
        $this->line('Add "APP_THEME='.$theme.'" to your .env file to use it');
    }
}
