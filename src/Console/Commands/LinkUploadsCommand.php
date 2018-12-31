<?php

namespace LaPress\Commands\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;

class LinkUploadsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'lapress:uploads:link';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Link uploads directory';
    /**
     * @var Filesystem
     */
    private $files;

    /**
     * Create a new command instance.
     *
     * @param Filesystem $files
     */
    public function __construct(Filesystem $files)
    {
        parent::__construct();
        $this->files = $files;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $uploadsPath = storage_path('/uploads');
        try {
            $this->files->makeDirectory($uploadsPath);

        } catch (\Exception $e) {

        }
        $this->files->put($uploadsPath.'/.gitignore', "*\n!.gitignore");

        try {
            $this->files->link(
                $uploadsPath,
                storage_path('wordpress/wp-content/uploads')
            );
        } catch (\Exception $e) {

        }

    }
}
