<?php namespace Chapusoft\Faucet\Facades;

use Illuminate\Support\Facades\Facade;

class Faucet extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'faucet';
    }
}
