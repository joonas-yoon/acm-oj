<?php namespace App\Modules\Shell\Composers;

use App;
use Config;
use Lang;
use Modules;
use Menu;
use Auth;
use Illuminate\Contracts\View\View;
use Illuminate\Support\ServiceProvider;

class NavigationComposer {

    /**
     * The generated menu.
     *
     * @var \C5\AppKit\Menus\MenuBuilder
     */
    protected $menu;

    /**
     * Create a new profile composer.
     *
     * @param  UserRepository  $users
     * @return void
     */
    public function __construct()
    {
        $this->generateNavigation(); 
    }

    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $view->with('menu_admin_left', $this->menu);
    }

	/**
	 * Generate the admin navigation
	 *
	 **/
    protected function generateNavigation() {
    	$this->menu = Menu::makeAndReturn('menu_admin_left', function($menu) {

						$user = Auth::user();
						$modules = Modules::navigable();

						foreach ($modules as $module) {
							$item = $menu->add($module['menuText'], $module['redirect'])
									->icon($module['icon'])
									->data('requiresAccess', $module['requiresAccess']);
							if ($module['requiresAccess']) {
								$item->data('access', $module['requiredAccess']);
							}

							if( isset($module['navigation']) && count($module['navigation']) > 0 ) {
								foreach ($module['navigation'] as $subitem) {
									$sub = $item->add($subitem['menuText'], $subitem['redirect'])
											->data('requiresAccess', $subitem['requiresAccess']);
									if ($subitem['requiresAccess']) {
										$sub->data('access', $subitem['requiredAccess']);
									}
								}
							}
						}
					});
    }
}