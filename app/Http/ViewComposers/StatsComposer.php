<?php
namespace App\Http\ViewComposers;

use Illuminate\Contracts\View\View;
use Illuminate\Users\Repository as UserRepository;
use DB;

class StatsComposer
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
        $stats = DB::table('transfers')
                     ->select(DB::raw('DATE(created_at) as date, SUM(amount) as amount, Count(Distinct ip) as users'))
                     ->groupBy('date')
                     ->take(5)
                     ->orderBy('date', 'desc')
                     ->get();
                     
        $view->with('stats', $stats);
    }
}
