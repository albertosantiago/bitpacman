<?php namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class ComposerServiceProvider extends ServiceProvider
{

    public function boot()
    {
        view()->composer(
            'admin.widgets.stats',
            'App\Http\ViewComposers\StatsComposer'
        );
        view()->composer(
            'admin.widgets.messages_menu',
            'App\Http\ViewComposers\AdminMessagesComposer'
        );
        view()->composer(
            'widgets.langSelector',
            'App\Http\ViewComposers\LangSelectorComposer'
        );
    }

    public function register()
    {
    }
}
