<?php namespace Chapusoft\Faucet;

use Chapusoft\Faucet\Faucet;
use Illuminate\Support\ServiceProvider;

class FaucetServiceProvider extends ServiceProvider
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
            __DIR__.'/config/faucet.php',
            'faucet'
        );

        $this->app->bind('faucet', function () {
            return new Faucet(app('config')->get('faucet'));
        });
    }

    protected function handleConfig()
    {
        $configPath = __DIR__ . '/config/faucet.php';
        $this->publishes([$configPath => $this->getConfigPath()], 'config');
    }

    /**
     * Get the config path
     *
     * @return string
     */
    protected function getConfigPath()
    {
        return config_path('faucet.php');
    }

    /**
     * Publish the config file
     *
     * @param  string $configPath
     */
    protected function publishConfig($configPath)
    {
        $this->publishes([$configPath => config_path('faucet.php')], 'config');
    }


    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [
            'faucet',
        ];
    }
}
