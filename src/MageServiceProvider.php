<?php

namespace Omatech\Mage\Core;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\ServiceProvider;
use Omatech\Mage\Core\Providers\BindingServiceProvider;

class MageServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        $this->publishes($this->migrations(), 'mage-migrations');
    }

    /**
     * Register the application services.
     */
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__.'/../config/config.php',
            'mage'
        );

        $this->mergeConfigFrom(
            __DIR__.'/../config/permission.php',
            'permission'
        );

        $this->mergeConfigFrom(
            __DIR__.'/../config/auth.providers.php',
            'auth.providers'
        );

        $this->mergeConfigFrom(
            __DIR__.'/../config/auth.guards.php',
            'auth.guards'
        );

        $this->mergeConfigFrom(
            __DIR__.'/../config/translation-loader.php',
            'translation-loader'
        );

        $this->app->register(BindingServiceProvider::class);
    }

    public function migrations()
    {
        $migrations = [];

        $filesystem = new Filesystem();
        $source = __DIR__.'/database/migrations/';
        $destination = $this->app->databasePath().DIRECTORY_SEPARATOR.'migrations'.DIRECTORY_SEPARATOR;

        foreach ($filesystem->files($source) as $index => $file) {
            $sourceFileName = $file->getFilename();
            $migrationName = substr($sourceFileName, 18, strlen($sourceFileName));

            $fileExists = 0 != count($filesystem->glob($destination.'*'.$migrationName));

            if (! $fileExists) {
                $destinationFileName = date('Y_m_d').'_'.str_pad($index, 6, '0').'_'.$migrationName;
                $migrations[$source.$sourceFileName] = $destination.$destinationFileName;
            }
        }

        return $migrations;
    }
}
