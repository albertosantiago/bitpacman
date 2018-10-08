<?php namespace Chapusoft\SolveMedia;

use Chapusoft\SolveMedia\SolveMedia;
use Illuminate\Support\ServiceProvider;

class SolveMediaServiceProvider extends ServiceProvider
{

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadViewsFrom(__DIR__ . '/views', 'solvemedia');
        $this->addValidator();
        $this->handleConfig();
    }

    /**
     * Extends Validator to include a solvemedia type
     */
    public function addValidator()
    {
        $this->app->validator->extendImplicit('solvemedia', function ($attribute, $value, $parameters) {
        
            $solvemedia = app('solvemedia.service');
            $challenge  = app('Input')->get('adcopy_challenge');
            $response   = app('Input')->get('adcopy_response');

            return $solvemedia->check($challenge, $response);
        }, 'Please ensure that you are a human!');
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__.'/config/solvemedia.php',
            'solvemedia'
        );
        $this->app->bind('solvemedia.service', function () {
        
            return new Service\CheckSolveMedia;
        });
        $this->app->bind('solvemedia', function () {
            return new SolveMedia(app('config')->get('solvemedia'));
        });
    }

    protected function handleConfig()
    {
        $configPath = __DIR__ . '/config/solvemedia.php';
        $this->publishes([$configPath => $this->getConfigPath()], 'config');
    }

    /**
     * Get the config path
     *
     * @return string
     */
    protected function getConfigPath()
    {
        return config_path('solvemedia.php');
    }

    /**
     * Publish the config file
     *
     * @param  string $configPath
     */
    protected function publishConfig($configPath)
    {
        $this->publishes([$configPath => config_path('solvemedia.php')], 'config');
    }


    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [
            'solvemedia',
        ];
    }
}
