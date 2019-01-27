<?php
namespace LaPress\Commands\Console\Commands;

use Artisan;
use Illuminate\Console\Command;
/**
 * @author    Sebastian Szczepański
 * @copyright ably
 */
class SearchImportCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'lapress:search:import';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import post types for scout';

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
        Artisan::call('scout:import', ['model' => 'App\\Models\\Post']);
        foreach (config('wordpress.posts.types') as $type => $model) {
            Artisan::call('scout:import', ['model' => $model]);
        }
    }
}
