<?php namespace Chapusoft\HiperCaptcha\Facades;

use Illuminate\Support\Facades\Facade;

class HiperCaptcha extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'hipercaptcha';
    }
}
