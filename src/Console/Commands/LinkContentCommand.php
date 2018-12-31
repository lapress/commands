<?php

namespace LaPress\Commands\Console\Commands;

use Illuminate\Console\Command;

class LinkContentCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'lapress:content:link';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Link content directory';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $contentPath = storage_path('content');

        try {
            $this->laravel->make('files')->link(
                $contentPath,
                storage_path('wordpress/wp-content/uploads')
            );
        } catch (\Exception $e) {

        }
    }
}
