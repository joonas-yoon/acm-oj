<?php namespace App\Modules\Shell\Composers;

use App;
use Config;
use Lang;
use Widgets;
use Auth;
use Illuminate\Contracts\View\View;
use Illuminate\Support\ServiceProvider;

class SidebarWidgetsComposer {

    /**
     * The generated menu.
     *
     * @var array
     */
    protected $widgets;

    /**
     * Create a new profile composer.
     *
     * @param  UserRepository  $users
     * @return void
     */
    public function __construct()
    {
        $this->getWidgets();
    }

    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $view->with('sidebar_widgets', $this->widgets);
    }

	/**
	 * Generate the admin navigation
	 *
	 **/
    protected function getWidgets() {
    	$this->widgets = Widgets::enabled();
        \Log::info($this->widgets);
    }
}