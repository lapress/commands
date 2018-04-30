<?php

namespace LaPress\Commands\Console\Commands;

use Illuminate\Console\Command;

class ThemeLinkCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'theme:link';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a symbolic link for theme';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        try {
            $this->laravel->make('files')->link(
                base_path('theme'), storage_path('wordpress/wp-content/themes/'.config('app.name'))
            );
        } catch (\Exception $e) {
            $this->error($e->getMessage());
        }

        try {
            $this->laravel->make('files')->link(
                base_path('theme'), public_path('theme')
            );
        } catch (\Exception $e) {
            $this->error($e->getMessage());
        }

        $this->info('The "'.config('app.name').'" theme directory has been linked.');
    }
}
