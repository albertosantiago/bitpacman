<?php namespace Chapusoft\SolveMedia;

require_once "solvemedia.php";
use App;

class SolveMedia
{

    public function __construct($config)
    {
        $this->config = $config;
    }

    public function render()
    {
        $locale  = App::getLocale();
        $options =    "<script type='text/javascript'>
                        	var ACPuzzleOptions = {
                        		theme:	'black',
                        		lang:	'$locale',
                        		size:	'300x150'
                            };
                        </script>";
        return $options.solvemedia_get_html($this->config['public_key']);
    }
}
