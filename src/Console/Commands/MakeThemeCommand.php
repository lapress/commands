<?php

namespace LaPress\Commands\Console\Commands;

use Illuminate\Console\Command;

class MakeThemeCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'lapress:theme:make {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create lapress theme';

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
        // create directory structure
    }
}
