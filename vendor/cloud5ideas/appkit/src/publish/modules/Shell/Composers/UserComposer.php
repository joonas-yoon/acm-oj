<?php namespace App\Modules\Shell\Composers;

use App;
use Config;
use Auth;
use Illuminate\Contracts\View\View;
use Illuminate\Support\ServiceProvider;

class UserComposer {

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
            $view->with('this_user', $this->user);
            $view->with('user_name', sprintf('%s %s', $this->user->first_name, $this->user->last_name));
            $view->with('user_email', $this->user->email);
            $view->with('user_id', $this->user->id);
            $view->with('is_superuser', $this->user->is_superuser);
            $view->with('user_image', $this->user->image);
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