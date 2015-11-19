<?php namespace App\Modules\Users\Composers;

use App;
use Config;
use Auth;
use Illuminate\Contracts\View\View;
use Illuminate\Support\ServiceProvider;

class UsersPermissionsComposer {

    /**
     * The authenticated user.
     *
     * @var \App\User
     */
    protected $user;

    /**
     * Create a new profile composer.
     *
     * @return void
     */
    public function __construct()
    {
        $this->getUser();
    }

    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
        if (Auth::check()) {
            $view->with('can_view_users', $this->user->can('view.users'));
            $view->with('can_create_users', $this->user->can('create.users'));
            $view->with('can_edit_users', $this->user->can('edit.users'));
            $view->with('can_delete_users', $this->user->can('delete.users'));
            $view->with('can_disable_users', $this->user->can('disable.users'));
            $view->with('can_enable_users', $this->user->can('enable.users'));
            $view->with('can_set_permissions', $this->user->can('set.user.permissions'));
            
        }
    }

    /**
     * Generate the admin navigation
     *
     **/
    protected function getUser() {
        if (Auth::check()) {
            $this->user = Auth::user();
        }
    }
}