<?php namespace Chapusoft\HiperCaptcha;

use Chapusoft\SolveMedia\SolveMedia;
use Illuminate\Support\ServiceProvider;

class HiperCaptchaServiceProvider extends ServiceProvider
{

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadViewsFrom(__DIR__ . '/views', 'hipercaptcha');
        $this->addValidator();
        $this->handleConfig();
    }

    /**
     * Extends Validator to include a hipercaptcha type
     */
    public function addValidator()
    {
        $this->app->validator->extendImplicit('hipercaptcha', function ($attribute, $value, $parameters) {
            $hipercaptcha = app('hipercaptcha.service');
            return $hipercaptcha->check($attribute, $value, $parameters);
        }, 'Please ensure that you are a human!');

        $this->loadViewsFrom(__DIR__ . '/views', 'hipercaptcha');
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__.'/config/hipercaptcha.php',
            'hipercaptcha'
        );
        $this->app->bind('hipercaptcha.service', function () {
            return new Service\CheckHiperCaptcha;
        });
        $this->app->bind('hipercaptcha', function () {
            return new HiperCaptcha(app('config')->get('hipercaptcha'));
        });
    }

    protected function handleConfig()
    {
        $configPath = __DIR__ . '/config/hipercaptcha.php';
        $this->publishes([$configPath => $this->getConfigPath()], 'config');
    }

    /**
     * Get the config path
     *
     * @return string
     */
    protected function getConfigPath()
    {
        return config_path('hipercaptcha.php');
    }

    /**
     * Publish the config file
     *
     * @param  string $configPath
     */
    protected function publishConfig($configPath)
    {
        $this->publishes([$configPath => config_path('hipercaptcha.php')], 'config');
    }


    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [
            'hipercaptcha',
        ];
    }
}
