<?php namespace Chapusoft\Ad;

use Chapusoft\Ad\Ad;
use Illuminate\Support\ServiceProvider;

class AdServiceProvider extends ServiceProvider
{

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->handleConfig();
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__.'/config/ad.php',
            'ad'
        );

        $this->app->bind('ad', function () {
            return new Ad(app('config')->get('ad'));
        });
    }

    protected function handleConfig()
    {
        $configPath = __DIR__ . '/config/ad.php';
        $this->publishes([$configPath => $this->getConfigPath()], 'config');
    }

    /**
     * Get the config path
     *
     * @return string
     */
    protected function getConfigPath()
    {
        return config_path('ad.php');
    }

    /**
     * Publish the config file
     *
     * @param  string $configPath
     */
    protected function publishConfig($configPath)
    {
        $this->publishes([$configPath => config_path('ad.php')], 'config');
    }


    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [
            'ad',
        ];
    }
}
