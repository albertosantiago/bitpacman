<?php namespace Chapusoft\XWhois;

use Chapusoft\XWhois\XWhois;
use Illuminate\Support\ServiceProvider;

class XWhoisServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->handleConfig();
    }

    public function register()
    {
        $this->app->bind('whois', function () {
            return new XWhois();
        });
    }

    protected function handleConfig()
    {
        return;
    }

    public function provides()
    {
        return [
            'whois',
        ];
    }
}
