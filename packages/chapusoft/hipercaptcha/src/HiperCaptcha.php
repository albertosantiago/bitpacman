<?php namespace Chapusoft\HiperCaptcha;

require_once "lib/solvemedia.php";
require_once "lib/imagecaptcha/imagecaptcha.lib.php";
require_once "lib/recaptcha-php-1.11/recaptchalib.php";

use App;

class HiperCaptcha
{

    public function __construct($config)
    {
        $this->config = $config;
    }

    public function render(){
        $captcha = rand(1,5);
        app('request')->session()->put('hipercaptcha_current_captcha', $captcha);

        $html = "<input type='hidden' name='hipercaptcha' value='1' />";
        switch($captcha){
            case 1:
                $html .= $this->renderSolveMedia();
                break;
            case 2:
                $html .= $this->renderRecaptcha();
                break;
            case 3:
                $html .= $this->renderImageCaptcha();
                break;
            default:
                $html .= $this->renderImageCaptcha();
                break;
        }
        return $html;
    }

    public function renderImageCaptcha(){
        return image_captcha_html();
    }

    public function renderRecaptcha()
    {
        $data = array(
            'public_key' => $this->config['recaptcha']['public_key']
        );
        $data['lang'] =  App::getLocale();
        return app('view')->make('hipercaptcha::recaptcha', $data);
    }

    public function renderSolveMedia()
    {
        $locale  = App::getLocale();
        $options = "<script type='text/javascript'>
                        	var ACPuzzleOptions = {
                        		theme:	'black',
                        		lang:	'$locale',
                        		size:	'300x150'
                            };
                        </script>";
        return $options.solvemedia_get_html($this->config['solvemedia']['public_key']);
    }
}
