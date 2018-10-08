<?php
namespace Chapusoft\XWhois;

use Cache;
use Carbon\Carbon;

class XWhois
{
    private $whois;

    public function __construct(){
        $this->whois = new \Whois();
        $this->whois->deepWhois = false;
    }

    public function lookup($clientIp)
    {
        $cacheName = 'lookups-'.$clientIp;
        if (Cache::has($cacheName)) {
            return Cache::get($cacheName);
        }
        $ret = $this->whois->lookup($clientIp, false);
        $expiresAt = Carbon::now()->addDays(20);
        Cache::put($cacheName, $ret, $expiresAt);
        return $ret;
    }
}
