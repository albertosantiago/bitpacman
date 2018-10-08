<?php namespace Chapusoft\RobotDetect\Middleware;

use Monolog\Handler\SyslogHandler;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Monolog\Formatter\LineFormatter;
use Monolog\Handler\ErrorLogHandler;
use Monolog\Handler\RotatingFileHandler;
use Monolog\Processor\IntrospectionProcessor;
use Route;
use Closure;
use Session;
use File;
use Faucet;
use DB;
use XWhois;
use Carbon\Carbon;
use RobotDetect as RobotDetectFacade;


class RobotDetect
{

    protected $logFileLocation = 'logs/';
    protected $logFileName = 'RobotDetect.log';

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $this->request = $request;
        $route  = Route::current();
        $path   = $route->getPath();
        $action = $route->getActionName();
        $params = $request->all();

        $log  = $this->getLog();
        $time = time();

        $register = $request->session()->get("robot-detect.registry");
        $register[$action] = array("time" => $time, "params" => $params);
        $request->session()->put("robot-detect.registry", $register);

        if ($action=="App\Http\Controllers\MainController@setpoints") {
            foreach ($register as $key => $value) {
                if ($key=="App\Http\Controllers\MainController@index") {
                    $diffTime = $time - $value['time'];
                    $points   = $params['points'];
                    $this->checkRobot($diffTime, $points);
                    return $next($request);
                }
            }
            $this->setRobot(true, "Automatic puntuaction attemp.");
        }
        if ($action=="App\Http\Controllers\MainController@getReward") {
            foreach ($register as $key => $value) {
                if ($key=="App\Http\Controllers\MainController@index") {
                    $diffTime = $time - $value['time'];
                    if($diffTime<18){
                        return redirect()->action('MainController@index');
                    }else{
                        return $next($request);
                    }
                }
            }
            $this->log("ROBOT DETECTADO: Intento de acceso inmediato a la recompensa, redireccionamos al index.");
            return redirect()->action('MainController@index');
        }
        if($action=="App\Http\Controllers\MainController@sendReward"){
            $this->checkAbuse($request);
        }
        if ($action=="App\Http\Controllers\MainController@success") {
            $request->session()->put("robot-detect.registry", []);
        }
        return $next($request);
    }

    public function checkRobot($diffTime, $points)
    {
        $isRobot = $this->request->session()->get("robot-detect.isRobot");
        if($isRobot){
            $this->log("ROBOT DETECTADO PREVIAMENTE VOLVIENDO A INTENTAR OPERACIÓN :D");
            return;
        }
        if(empty($diffTime)){
            $this->log("ROBOT DETECTADO:".$points." en 0 segundos...");
            $this->setRobot(true, "Sin tiempo de espera detectado.");
            return;
        }
        $startPoints = Faucet::getDirectPayment();
        $med = ($points - $startPoints) / $diffTime;
        if ($med > 2.85) {
            $this->log("ROBOT DETECTADO:".$med." puntos por segundo...");
            $this->setRobot(true, "Puntuaction bigger and faster than posible.");
        } else {
            $this->log("MEDIA TIEMPO PUNTUACTION:".$med." puntos por segundo...");
        }
    }

    public function checkAbuse($request){

        $now   = Carbon::now();
        $freedomDate = Carbon::now()->modify('+1 year');

        $address  = $request->input('address');
        if(empty($address)){
            return;
        }
        $clientIp = $request->getClientIp();

        //Comprobamos si se ha sobrado con la IP
        $updateTime = Carbon::now()->modify('-24 hours');
        $total = DB::table('transfers')->where('ip', '=', $clientIp)
                                    ->where('referral', '=', 0)
                                    ->where('updated_at', '>', $updateTime)
                                    ->count();
        if($total>7){
            $this->log("ABUSO DETECTADO: IP ".$clientIp." DID MORE THAN 6 TRANSFERS TODAY");
            DB::table("banned")->insert([
                'address' => $address,
                'ip' => $clientIp,
                'created_at' => $now,
                'updated_at' => $now,
                'freedom_date' => $freedomDate,
                'reason' => 'More than 6 transactions with the same ip'
            ]);
        }
        //Comprobamos si se ha sobrado con la Dirección
        $total = DB::table('transfers')->where('address', '=', $address)
                                    ->where('referral', '=', 0)
                                    ->where('updated_at', '>', $now->modify('-24 hours'))
                                    ->count();
        if($total>7){
            $this->log("ABUSO DETECTADO: ADDRESS ".$address." DID MORE THAN 6 TRANSFERS TODAY");
            DB::table("banned")->insert([
                'address' => $address,
                'ip' => $clientIp,
                'created_at' => $now,
                'updated_at' => $now,
                'freedom_date' => $freedomDate,
                'reason' => 'More than 6 transactions with the same address'
            ]);
        }
    }


    public function setRobot($bool, $reason='Unknow')
    {
        $freedomDate = Carbon::now()->addHours(24);
        $now = Carbon::now();
        DB::table("banned")->insert([
            'address' => null,
            'ip' => $this->request->getClientIp(),
            'created_at' => $now,
            'updated_at' => $now,
            'freedom_date' => $freedomDate,
            'reason' => $reason
        ]);
        $this->request->session()->put("robot-detect.isRobot", $bool);
    }

    public function log($text){
        $ip = $this->request->getClientIp();
        $this->getLog()->info($ip." ".$text);
    }

    /**
     * Returns a valid log file, re-using an existing one if possible
     *
     * @return \Monolog\Logger
     */
    public function getLog()
    {
        // Set a log file
        if (!isset($this->log)) {
            $this->setLog();
        }
        // If it's been set somewhere else, re-create it
        if ('Monolog\Logger' !== get_class($this->log)) {
            $this->setLog();
        }
        return $this->log;
    }

    /**
     * Sets the log file
     */
    public function setLog()
    {
        $this->log = new Logger('RobotDetectLog');
        // Make sure our directory exists
        if (!File::isDirectory(storage_path($this->logFileLocation))) {
            File::makeDirectory(storage_path($this->logFileLocation));
        }
        $handler = new RotatingFileHandler(storage_path($this->logFileLocation.$this->logFileName));
        $handler->setFormatter(new LineFormatter("[%datetime%] %channel%.%level_name%: %message% \n"));

        $this->log->pushHandler($handler);
        $this->log->pushProcessor(new IntrospectionProcessor());
    }
}
