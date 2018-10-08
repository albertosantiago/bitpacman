<?php namespace Chapusoft\RobotDetect\Facades;

use Illuminate\Support\Facades\Facade;

class RobotDetect extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'robot-detect';
    }
}
