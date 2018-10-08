<?php namespace Chapusoft\RobotDetect;

use Chapusoft\RobotDetect\RobotDetect;
use Illuminate\Support\ServiceProvider;

class RobotDetectServiceProvider extends ServiceProvider
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
            __DIR__.'/config/robotdetect.php',
            'robot-detect'
        );

        $this->app->bind('robot-detect', function () {
            return new RobotDetect(app('config')->get('robot-detect'));
        });
    }

    protected function handleConfig()
    {
        $configPath = __DIR__ . '/config/robotdetect.php';
        $this->publishes([$configPath => $this->getConfigPath()], 'config');
    }

    /**
     * Get the config path
     *
     * @return string
     */
    protected function getConfigPath()
    {
        return config_path('robotdetect.php');
    }

    /**
     * Publish the config file
     *
     * @param  string $configPath
     */
    protected function publishConfig($configPath)
    {
        $this->publishes([$configPath => config_path('robotdetect.php')], 'config');
    }


    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [
            'robot-detect',
        ];
    }
}
