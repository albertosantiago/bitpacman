<?php namespace Chapusoft\HiperCaptcha\Service;

require_once __DIR__."/../lib/solvemedia.php";
require_once __DIR__."/../lib/imagecaptcha/imagecaptcha.lib.php";
require_once __DIR__."/../lib/recaptcha-php-1.11/recaptchalib.php";

class CheckHiperCaptcha
{
    protected $request;

    public function check($attribute, $value, $parameters)
    {
        $captcha = app('request')->session()->get('hipercaptcha_current_captcha');
        switch($captcha){
            case 1:
                return $this->checkSolveMedia();
                break;
            case 2:
                return $this->checkRecaptcha();
                break;
            case 3:
                return $this->checkImageCaptcha();
                break;
            default:
                return $this->checkImageCaptcha();
                break;
        }
    }

    public function checkImageCaptcha()
    {
        return image_captcha_validate();
    }

    public function checkRecaptcha()
    {
        $value = app('Input')->get('g-recaptcha-response');
        $parameters = http_build_query(array(
            'secret'    => app('config')->get('hipercaptcha.recaptcha.private_key'),
            'remoteip'  => app('request')->getClientIp(),
            'response'  => $value,
        ));

        $url = 'https://www.google.com/recaptcha/api/siteverify?' . $parameters;
        $checkResponse = null;

        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_HEADER, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_TIMEOUT, 4);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        $checkResponse = curl_exec($curl);

        if(is_null($checkResponse) || empty($checkResponse))
        {
            return false;
        }
        $decodedResponse = json_decode($checkResponse, true);
        return $decodedResponse['success'];
    }

    public function checkSolveMedia()
    {
        $challenge  = app('Input')->get('adcopy_challenge');
        $response   = app('Input')->get('adcopy_response');
        $privKey = app('config')->get('hipercaptcha.solvemedia.private_key');
        $hashKey = app('config')->get('hipercaptcha.solvemedia.auth_hash_key');

        $solvemedia_response = solvemedia_check_answer(
            $privKey,
            app('request')->getClientIp(),
            $challenge,
            $response,
            $hashKey
        );

        if ($solvemedia_response->is_valid) {
            return true;
        } else {
            return false;
        }
    }
}
