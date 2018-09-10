<?php

namespace LaPress\Commands\Console\Commands;

use Illuminate\Console\Command;
use LaPress\Commands\Services\Theme;

class ThemeLinkCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'lapress:themes:link';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a symbolic link for theme';

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
        $directories = \File::directories(resource_path('themes/'));

        $this->info(sprintf('Found %d themes', count($directories)));

        foreach ($directories as $directory) {
            $this->linkDirectory(basename($directory));
        }
    }

    /**
     * @param string $directoryName
     */
    public function linkDirectory(string $directoryName)
    {
        try {
            $this->theme->linkPublic($directoryName);
        } catch (\Exception $e) {
            $this->error($e->getMessage());
        }

        try {
            $this->theme->link($directoryName);
        } catch (\Exception $e) {
            $this->error($e->getMessage());
        }

        $this->info('The "'.$directoryName.'" theme directory has been linked.');
    }
}
