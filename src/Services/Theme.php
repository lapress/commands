<?php

namespace LaPress\Commands\Services;

use Illuminate\Filesystem\Filesystem;

/**
 * @author Sebastian Szczepański
 * @copyright Ably
 */
class Theme
{
    /**
     * @var Filesystem
     */
    private $files;
    private $stubsDir;

    /**
     * Theme constructor.
     * @param Filesystem $files
     */
    public function __construct(Filesystem $files)
    {
        $this->files = $files;
    }

    public function create(string $name, string $stubsDir)
    {
        $this->stubsDir = $stubsDir;
        // create theme dirs
        $this->createThemeDirs($name);
        $this->initTailwindCss($name);
        $this->createSassFiles($name);
        $this->createJsFiles($name);
        $this->createStylesheet($name);
        $this->createPhpFiles($name);
        $this->createEmptyViews($name);
    }

    public function createThemeDirs(string $name)
    {
        $directories = [
            '',
            'js',
            'js/components',
            'public',
            'sass',
            'sass/base',
            'sass/components',
            'sass/layout',
            'views',
        ];

        foreach ($directories as $directory) {
            try {
                $this->files->makeDirectory(themes($name.'/'.$directory));
            } catch (\Exception $e) {

            }

        }
    }

    /**
     * @param string $directoryName
     */
    public function link(string $directoryName)
    {
        $this->files->link(
            themes($directoryName.'/public'),
            storage_path('content/themes/'.$directoryName)
        );
    }

    /**
     * @param string $directoryName
     */
    public function linkPublic(string $directoryName)
    {
        $this->files->link(
            themes($directoryName.'/public'),
            public_path($directoryName)
        );
    }

    private function initTailwindCss(string $name)
    {
        shell_exec('./node_modules/.bin/tailwind init '.themes($name.'/js/config/style.config.js'));
    }

    private function createSassFiles(string $name)
    {
        $files = $this->files->allFiles($this->stubsDir.'/sass');
        foreach ($files as $file) {
            $source = $file->getRelativePathname();
            $destination = str_replace('.stub', '', $source);

            copy($this->stubsDir.'/sass/'.$source, themes($name.'/sass/'.$destination));
        }
    }

    private function createJsFiles(string $name)
    {
        $files = $this->files->allFiles($this->stubsDir.'/js');
        foreach ($files as $file) {
            $source = $file->getRelativePathname();
            $destination = str_replace('.stub', '', $source);

            copy($this->stubsDir.'/js/'.$source, themes($name.'/js/'.$destination));
        }
    }

    public function createStylesheet($name)
    {
        $this->createFile($name, 'style.css.stub', 'public/style.css');
    }

    public function createPhpFiles($name)
    {
        $this->makeDirs($name, [
            'public/inc',
            'public/inc/pages',
            'public/inc/metaboxes',
            'public/inc/metaboxes/templates',
        ]);

        $files = $this->files->allFiles($this->stubsDir.'/php');

        foreach ($files as $file) {
            $source = $file->getRelativePathname();
            $destination = str_replace('.stub', '', $source);
            $this->createFile($name, 'php/'.$source, 'public/'.$destination);
        }

        $this->files->put(themes($name.'/public/inc/pages/'.$name.'.php'), '');
        $this->files->put(themes($name.'/public/inc/pages/seo.php'), '');
    }

    public function createEmptyViews($name)
    {
        $this->makeDirs($name, [
            'views/components',
            'views/content',
            'views/lists',
            'views/meta',
            'views/partials',
            'views/svg',
        ]);

        $files = $this->files->allFiles($this->stubsDir.'/views');

        foreach ($files as $file) {
            $source = $file->getRelativePathname();
            $destination = str_replace('.stub', '', $source);
            $this->createFile($name, 'views/'.$source, 'views/'.$destination);
        }
    }

    public function makeDirs($theme, $paths = [])
    {
        foreach ($paths as $path) {
            $this->makeDir($theme, $path);
        }
    }

    public function makeDir($theme, $path)
    {
        $dir = themes($theme.'/'.$path);

        if ($this->files->exists($dir)) {
            return true;
        }

        $this->files->makeDirectory($dir);
    }

    public function createFile(string $theme, string $source, string $destination)
    {
        $content = file_get_contents($this->stubsDir.'/'.$source);

        $content = str_replace('{Theme}', ucfirst($theme), $content);
        $content = str_replace('{theme}', str_slug($theme), $content);

        $this->files->put(themes($theme.'/'.$destination), $content);
    }
}
