<?php
namespace App\Http\ViewComposers;

use Illuminate\Contracts\View\View;
use Illuminate\Users\Repository as UserRepository;
use DB;

class LangSelectorComposer
{
    /**
     * The user repository implementation.
     *
     * @var UserRepository
     */
    protected $users;

    /**
     * Create a new profile composer.
     *
     * @param  void
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $data = array();
        $data['langs'] = array();
        $locale = app()->getLocale();
        $langs  = app()->config->get('app.locales');
        foreach ($langs as $key => $value) {
            if ($key == $locale) {
                $data['selectedLang'] = new \stdClass();
                $data['selectedLang']->code = $key;
                $data['selectedLang']->literal = $value;
            } else {
                $lang = new \StdClass();
                if ($key=='en') {
                    $lang->code    = '';
                } else {
                    $lang->code    = $key;
                }
                $lang->literal = $value;
                $data['langs'][] = $lang;
            }
        }
        $view->with($data);
    }
}
