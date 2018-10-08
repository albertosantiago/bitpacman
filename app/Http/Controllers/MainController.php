<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Classes\Util as Util;
use App\Transfer;
use App\ExtraAward;
use Validator;
use DB;
use Debugbar;
use Session;
use Carbon\Carbon;
use Faucet;
use Log;
use Cache;
use Config;
use RobotDetect;
use App;

class MainController extends Controller
{
    const WAIT_TIME = 120;

    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('robot-detect');
        $this->middleware('guest');
    }

    /**
     * @return Response
     */
    public function about()
    {
        return view('public/about');
    }

    /**
     * @return Response
     */
    public function index(Request $request)
    {
        //Guardamos si el usuario viene con referencia.
        $referral = trim($request->input("ref"));
        if (!empty($referral)) {
            $request->session()->set("referral", $referral);
        }

        //Chequeamos la dirección y la IP para ver si el usuario esta fuera de tiempo.
        $ret = $this->checkIp($request);
        if ($ret) {
            $updatedAt = Carbon::createFromFormat('Y-m-d H:i:s', $ret->updated_at);
            $now = Carbon::now();
            $minutes = self::WAIT_TIME - $now->diffInMinutes($updatedAt);
            Session::flash('no-ip', trans('app.index.no-ip', ['minutes' => $minutes]));
        } else {
            //Comprobamos la dirección
            $address = $request->session()->get("address");
            if(!empty($address)){
                $ret = $this->checkAddress($address);
            }else{
                $ret = false;
            }
            if($ret){
                $updatedAt = Carbon::createFromFormat('Y-m-d H:i:s', $ret->updated_at);
                $now = Carbon::now();
                $minutes = self::WAIT_TIME - $now->diffInMinutes($updatedAt);
                Session::flash('no-address', trans('app.index.no-address', ['minutes' => $minutes]));
            }else{
                //Comprobamos si tenemos fondos para pagar.
                $cacheId = 'maincontroller.index.balance';
                if (null === $ret = Cache::get($cacheId)) {
                    $ret = Faucet::getBalance();
                    Cache::put($cacheId, $ret, Config::get('app.cache.balance'));
                }
                if (!empty($ret['status'])&&($ret['status']=="200")) {
                    if ($ret['balance'] < Faucet::getMinBalance()) {
                        Session::flash('no-founds', trans('app.index.no-founds'));
                    }
                } else {
                    Session::flash('no-founds', trans('app.index.no-founds'));
                }
            }
        }
        //Chequeamos si hemos traspasado el limite diario.
        if ($this->checkMaxDaily()) {
            Session::flash('no-founds', trans('app.index.no-founds-maxDaily'));
        }
        //Chequeamos si esta baneado.
        $ret = RobotDetect::isBanned($request);
        if($ret){
            Session::flash('banned', trans('app.index.banned', ['freedom_date' => $ret->freedom_date]));
        }

        $ret = RobotDetect::isNastyHost($request);
        if($ret){
            Session::flash('banned', trans('app.index.nasty-host-banned'));
        }

        $directPayment = Faucet::getDirectPayment();
        $todayPayments = round($this->getTodayPayments());
        return view('public/bitpacman', ['directPayment'=>$directPayment,
                                        'todayPayments' => $todayPayments]);

    }

    public function pacmanjs(Request $request)
    {
        $request->session()->put('points', '');
        Debugbar::disable();
        //Usado en setpoints.
        $ajaxKey = md5(rand(10, 100000));
        $request->session()->put('ajaxkey', $ajaxKey);
        $ajaxKey = Util::encodeJsHex($ajaxKey);

        if(App::environment('testing')){
            $ajaxKey = '.......................................';
        }

        $maxTransfer = Faucet::getMaxTransfer();
        $startPoints = Faucet::getDirectPayment();
        return view('js/pacman', ['ajaxKey' => $ajaxKey,
                                  'max_transfer' => $maxTransfer,
                                  'start_points' => $startPoints,]);
    }

    public function setpoints(Request $request)
    {
        $sessionKey = $request->session()->get('ajaxkey');
        $ajaxKey    = trim($request->input('ajaxkey'));

        $request->session()->put('ajax-key', '');

        if (!empty($request->session()->get('points'))) {
            return ['status' => 'error',
                    'msg'    => 'You already set your points'];
        }
        if ($sessionKey!=$ajaxKey) {
            return  ['status' => 'error',
                     'msg' => 'Ajax Key problem :S'];
        }
        if (empty($ajaxKey)) {
            return  ['status' => 'error',
                     'msg' => 'Ajax Key problem :S'];
        }
        $request->session()->put('points', trim($request->input('points')));
        return ['status' => 'success',
                'msg' => 'Points set successfully'];
    }

    public function getReward(Request $request)
    {
        $points = $this->getPoints($request);
        return view('public/getreward', ['points' => $points]);
    }

    public function sendReward(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'address' => 'required:max:255',
            'hipercaptcha' => 'hipercaptcha',
        ]);

        if ($validator->fails()) {
            $fails = $validator->failed();
            $captchaAttemps = 0;
            if(!empty($fails['hipercaptcha'])){
                //Intento de resolución del captcha erroneo
                if ($request->session()->has('hipercaptcha_attemps')){
                    $captchaAttemps = 1 + $request->session()->get('hipercaptcha_attemps');
                }else{
                    $captchaAttemps = 1;
                }
                $request->session()->put('hipercaptcha_attemps', $captchaAttemps);
            }
            if($captchaAttemps>5){
                RobotDetect::banIp($request->getClientIp(), null, 48, 'Too many captcha attemps.');
                $this->clearSessionData($request);
                return redirect()->action("MainController@index");

            }
            return redirect()->action('MainController@getReward')
                                        ->withErrors($validator)
                                        ->withInput();
        }

        if ($this->checkIp($request)) {
            //Intento de volver a cobrar sin espera
            return redirect()->action('MainController@success');
        }

        $address   = trim($request->input('address'));

        if ($this->checkAddress($address)) {
            //Dirección Intentando volver a cobrar sin espera
            $validator->errors()->add('address', trans('app.sendreward.repeated-address'));
            return redirect()->action('MainController@getReward')
                                            ->withErrors($validator)
                                            ->withInput();
        }

        $shatoshis = $this->getPoints($request);
        $referral  = $request->session()->get("referral");

        if ($shatoshis > Faucet::getMaxTransfer()) {
            //INTENTO DE COBRAR MÁS DEL MAXIMO
            $request->session()->put('address', $address);
            $request->session()->put('payment-amount', $shatoshis);
            $this->registerTransfer($request, $address, 0, false, true);
            $this->clearSessionData($request);
            return redirect()->action('MainController@success');
        }

        if (RobotDetect::isRobot()) {
            //ROBOT LOCALIZADO AÑADIENDO FALSA TRANSFERENCIA
            $request->session()->put('address', $address);
            $request->session()->put('payment-amount', $shatoshis);
            $this->registerTransfer($request, $address, 0, false, true);
            $this->clearSessionData($request);
            return redirect()->action('MainController@success');
        }
        //Chequeamos si esta baneado.
        if(RobotDetect::isBanned($request)){
            //USUARIO BANEADO INTENTANDO REALIZAR TRANSFERENCIA
            $request->session()->put('address', $address);
            $request->session()->put('payment-amount', $shatoshis);
            $this->registerTransfer($request, $address, 0, false, true);
            $this->clearSessionData($request);
            return redirect()->action('MainController@success');
        }

        //Enviando datos al Faucet
        $ret = Faucet::send($address, $shatoshis);
        //Resultado conexión Faucet

        if ($ret['success']) {
            if (!empty($referral)) {
                $refShatoshis = Faucet::getReferralCommision($shatoshis);
                //Enviando comision por Referencia;
                $ret = Faucet::sendReferralEarnings($referral, $refShatoshis);
                //Resultado conexión Faucet
                $this->registerTransfer($request, $address, $refShatoshis, true);
            }
            $request->session()->put('address', $address);
            $request->session()->put('payment-amount', $shatoshis);
            $this->registerTransfer($request, $address, $shatoshis);
            $this->clearSessionData($request);
            $request->session()->put('extraAward', false);
            return redirect()->action('MainController@success');
        } else {
            $response = json_decode($ret['response']);
            if ($response->status == 402) {
                $validator->errors()->add('address', trans('app.sendreward.no-founds'));
            } else {
                $validator->errors()->add('address', trans('app.sendreward.incorrect-address'));
            }
            return redirect()->action('MainController@getReward')->withErrors($validator);
        }
    }

    public function success(Request $request)
    {
        $promotions = $this->getPromotionsRegisterObject($request);
        return view('public/success',['promotions' => $promotions]);
    }


    public function getExtraAward(Request $request)
    {
        //Intentando cobrar el premio por ir a la publicidad
        $extraAward = $request->session()->get('extraAward');
        if($extraAward){
            $request->session()->flash('extra-award-error', 'Sorry, you cannot get the promotion more than one time each');
            return redirect()->action('MainController@success');

        }
        $address = $request->session()->get('address');
        $ret = Faucet::send($address, 200);
        if(!$ret['success']){
            $request->session()->flash('extra-award-error', 'There was a problem with the request');
            return redirect()->action('MainController@success');
        }else{
            $promoSiteKey = $request->input('promositeKey');
            $url = null;
            switch($promoSiteKey){
                case "pornlists":
                    $locale = substr($request->server('HTTP_ACCEPT_LANGUAGE'), 0, 2);
                    switch($locale){
                        case 'es':
                            $url = 'http://pornolistas.com/search';
                            break;
                        case 'nl':
                            $url = 'http://pornolijsten.com/search';
                            break;
                        case 'de':
                            $url = 'http://pornolisten.de/search';
                            break;
                        default:
                            $url = 'http://pornlists.net/search';
                            break;
                    }
                    break;

                case "wetdogtv":
                    $url = "http://wetdog.tv/search";
                    break;

                case "omarsex":
                    $url = "http://omarsex.com/search";
                    break;

                case "grannylovers":
                    $url = "http://grannylovers.net/search";
                    break;
            }

            if(empty($url)){
                $request->session()->flash('extra-award-error', 'Unrecognized url');
                return redirect()->action('MainController@success');
            }
            //Accediendo a la publicidad
            $this->registerExtraAward($request, $address, 200);
            $request->session()->put('extraAward', '1');
            $this->registerPromoView($request, $promoSiteKey);
            return redirect($url);
        }
    }

    public function getPromotionsRegisterObject($request){
        $promotionsRegister = $request->session()->get('promotions_register');
        if(empty($promotionsRegister)){
            $promotionsRegister = $this->generateEmptyPromotionRegister();
            $request->session()->put('promotions_register', $promotionsRegister);
        }
        return $promotionsRegister;
    }

    public function registerPromoView($request, $promoSiteKey){
        $promotionsRegister = $this->getPromotionsRegisterObject($request);
        $promotionsRegister[$promoSiteKey]['views']+=1;
        $promotionsRegister[$promoSiteKey]['enabled'] = false;
        $cont = 0;
        foreach($promotionsRegister as $promotionKey => $values){
            if(!$values['enabled']){
                $cont++;
            }
        }
        if($cont>2){
            $promotionsRegister = $this->generateEmptyPromotionRegister();
        }
        $request->session()->put('promotions_register', $promotionsRegister);
    }

    public function generateEmptyPromotionRegister()
    {
        return [
            'pornlists' => [
                'views' => 0,
                'public_name' => "Pornlists",
                'enabled' => true
            ],
            'omarsex'   => [
                'views' => 0,
                'public_name' => "Omarsex",
                'enabled' => true
            ],
            'grannylovers' => [
                'views' => 0,
                'public_name' => "GrannyLovers",
                'enabled' => true
            ],
            'wetdogtv'  => [
                'views' => 0,
                'public_name' => "WetdogTv",
                'enabled' => true
            ]
        ];
    }


    public function registerTransfer($request, $address, $shatoshis,
                                        $referral=false, $scammer=false)
    {
        $ip = $request->getClientIp();
        $transfer = new Transfer();
        $transfer->ip = $ip;
        $transfer->address = $address;
        $transfer->amount = $shatoshis;
        $transfer->referral = $referral;
        $transfer->scammer = $scammer;
        return $transfer->save();
    }

    public function registerExtraAward($request, $address, $shatoshis)
    {
        $ip = $request->getClientIp();
        $extraAward = new ExtraAward();
        $extraAward->ip = $ip;
        $extraAward->address = $address;
        $extraAward->amount = $shatoshis;
        return $extraAward->save();
    }

    public function checkIp($request)
    {
        $clientIp = $request->getClientIp();
        $now = new \DateTime();
        $ips = DB::table('transfers')->where('ip', '=', $clientIp)
                                        ->where('updated_at', '>', $now->modify('-120 minutes'))
                                        ->orderBy('updated_at', 'desc')
                                        ->take(1)
                                        ->get();

        if (!empty($ips)) {
            return $ips[0];
        } else {
            return false;
        }
    }

    public function checkAddress($address)
    {
        $now = new \DateTime();
        $ips = DB::table('transfers')->where('address', '=', $address)
                                        ->where('updated_at', '>', $now->modify('-110 minutes'))
                                        ->orderBy('updated_at', 'desc')
                                        ->take(1)
                                        ->get();

        if (!empty($ips)) {
            return $ips[0];
        } else {
            return false;
        }
    }

    public function checkMaxDaily()
    {
        $todayPayments = $this->getTodayPayments();
        if ($todayPayments >= Faucet::getMaxDaily()) {
            return true;
        } else {
            return false;
        }
    }

    public function getTodayPayments()
    {
        $now = Carbon::now()->toDateString();
        $todayPayments = Transfer::select(
            DB::raw('SUM(amount) as total'))
                        ->whereRaw("DATE(updated_at) = '$now'")
                        ->get();

        return $todayPayments[0]->total;
    }

    public function clearSessionData($request)
    {
        $request->session()->forget('ajax-key');
        $request->session()->forget('points');
        $request->session()->forget('referral');
        $request->session()->forget('hipercaptcha_attemps');
    }


    public function getPoints($request)
    {
        $shatoshis  = $request->session()->get('points');
        $minPayment = Faucet::getDirectPayment();
        if (empty($shatoshis)||($shatoshis < $minPayment)) {
            $shatoshis = $minPayment;
            $request->session()->put('points', $shatoshis);
        }
        return $shatoshis;
    }
}
