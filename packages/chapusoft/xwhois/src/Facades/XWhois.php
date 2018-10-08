<?php namespace Chapusoft\XWhois\Facades;

use Illuminate\Support\Facades\Facade;

class XWhois extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'whois';
    }
}
