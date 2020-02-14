<?php

namespace LaPress\Commands\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;

/**
 * @author Sebastian Szczepański
 * @copyright Ably
 */
class InitWordpressConfigCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'lapress:install:wp-config';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install laPress WordPress config file';

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

    public function handle()
    {
        $wordpressSampleConfig = wordpress_path('wp-config-sample.php');
        if ($this->filesystem->exists($wordpressSampleConfig)) {
            $this->filesystem->delete($wordpressSampleConfig);
        }
        
        $this->filesystem->copy(
            __DIR__.'/stubs/wp-config.php.stub',
            wordpress_path('wp-config.php')
        );

    }
}
