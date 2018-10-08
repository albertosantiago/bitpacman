<?php namespace App\Http\Middleware;

use Closure;
use Cache;
use Agent;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\RedirectResponse;

class MyCache
{

    private $after = false;
    /**
     * Create a new filter instance.
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  $time
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $time = $this->getTime($request);
        $uri  = $request->path();
        if(Agent::isDesktop()){
            $screen = "_desktop";
        }else{
            $screen = "_mobile";
        }
        $key  = 'route_'.Str::slug($uri).$screen;

        if (Cache::has($key)) {
            return Cache::get($key);
        } else {
            $response = $next($request);
            Cache::put($key, $response->getContent(), $time);
            return $response;
        }
    }

    private function getTime($request)
    {
        $actions = $request->route()->getAction();
        return $actions['time'];
    }
}
