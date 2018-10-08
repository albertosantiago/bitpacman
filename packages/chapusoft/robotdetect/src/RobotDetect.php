<?php

namespace Chapusoft\RobotDetect;

use Monolog\Handler\SyslogHandler;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Monolog\Formatter\LineFormatter;
use Monolog\Handler\ErrorLogHandler;
use Monolog\Handler\RotatingFileHandler;
use Monolog\Processor\IntrospectionProcessor;
use File;
use Session;
use DB;
use XWhois;
use Carbon\Carbon;
use Cache;

class RobotDetect
{
    protected $logFileLocation = 'logs/';
    protected $logFileName = 'RobotDetect.log';
    protected $config = array();

    public function __construct($config)
    {
        $this->config = $config;
    }

    public function isBanned($request)
    {
        $this->request = $request;

        $clientIp = $request->getClientIp();
        $now = new \DateTime();
        $ret = DB::table('banned')->whereRaw(" ? REGEXP ip", [$clientIp])
                                    ->where('freedom_date', '>', $now)
                                    ->take(1)
                                    ->get();
        if ($ret) {
            $this->log("IP BANEADA INTENTANDO VOLVER A ENTRAR:".$clientIp);
            return $ret[0];
        }

        $address = trim($request->session()->get('address'));
        if ($address) {
            $ret = DB::table('banned')->where('address', '=', $address)
                                    ->where('freedom_date', '>', $now)
                                    ->take(1)
                                    ->get();
            if ($ret) {
                $this->log("ADDRESS BANEADA INTENTANDO VOLVER A ENTRAR:".$address);
                return $ret[0];
            }
        }
        /*
        * Chequeamos si pertenece a una red no permitida para no abusar del
        * servicio de host.
        **/
        $longClientIp = ip2long($clientIp);
        $now = new \DateTime();
        $ret = DB::table('banned_ranges')
                        ->where('start', '<=', $longClientIp)
                        ->where('end', '>=', $longClientIp)
                        ->where('freedom_date', '>', $now)
                    ->take(1)
                    ->get();
        if ($ret) {
            $this->log("IP BANEADA INTENTANDO VOLVER A ENTRAR:".$clientIp);
            if(!empty($this->config['ban_fuck'])){
                $this->log("Enviando respuesta puteante a:".$clientIp);
                $this->sendFakeResponse();
            }
            return $ret[0];
        }
    }

    public function banIp($ip, $address, $hours, $reason='Unknow'){

        DB::table('banned')->insert([
            'ip' => $ip,
            'address' => $address,
            'freedom_date' => Carbon::now()->addHours($hours),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
            'reason' => $reason
        ]);
    }

    public function isRobot()
    {
        return Session::get('robot-detect.isRobot');
    }

    public function isNastyHost($request){
        try{
            $ip = $request->getClientIp();
            $cacheName = 'nasty-hosts-'.$ip;
            if (Cache::has($cacheName)) {
                $ret = Cache::get($cacheName);
            }else{
                $ret = json_decode(file_get_contents('http://v1.nastyhosts.com/'.$ip));
                $expiresAt = Carbon::now()->addDays(7);
                Cache::put($cacheName, $ret, $expiresAt);
            }
        }catch(\ErrorException $e){
            return true;
        }
        if($ret->suggestion == "deny"){
            $this->log("IP BANEADA POR NASTY HOSTS");
            return true;
        }
        return false;
    }



    public function log($text){
        $ip = $this->request->getClientIp();
        $this->getLog()->info($ip." ".$text);
    }

    public function getLog()
    {
        if (!isset($this->log)) {
            $this->setLog();
        }
        if ('Monolog\Logger' !== get_class($this->log)) {
            $this->setLog();
        }
        return $this->log;
    }

    public function setLog()
    {
        $this->log = new Logger('RobotDetectLog');
        if (!File::isDirectory(storage_path($this->logFileLocation))) {
            File::makeDirectory(storage_path($this->logFileLocation));
        }
        $handler = new RotatingFileHandler(storage_path($this->logFileLocation.$this->logFileName));
        $handler->setFormatter(new LineFormatter("[%datetime%] %channel%.%level_name%: %message% \n"));
        $this->log->pushHandler($handler);
        $this->log->pushProcessor(new IntrospectionProcessor());
    }

    public function sendFakeResponse()
    {
        $randomFuck = rand(0,1);
        if($randomFuck==0){
            $this->log("Putada tipo php seleccionada.");
            $cont = 0;
            while($cont<100000){
                $cont++;
                echo " HOLA CARACOLA! $cont";
            }
            die;
        }else{
            $this->log("Putada tipo javascript seleccionada.");
            echo "<html><head></head><body><script type='text/javascript'>cont=1.2;while(true){cont=cont*3;cont = 0.343/cont;document.write(cont);}</script></body></html>";
        }
    }
}
