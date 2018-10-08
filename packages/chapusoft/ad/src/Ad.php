<?php namespace Chapusoft\Ad;

class Ad
{

    protected $service;
    protected $config = array();

    public function __construct($config)
    {
        $this->config = $config;
    }

    public function getSlot($id)
    {
        $env = getenv('APP_ENV');
        return $this->config[$env]['slots'][$id];
    }

    public function getDependencies()
    {
        $env = getenv('APP_ENV');
        return $this->config[$env]['dependencies'];
    }
}
