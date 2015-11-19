<?php namespace App\Modules\Users\Http\Controllers;

use Flash;
use Auth;
use Mail;
use App\User;
use App\Role;
use App\Permission;
use App\Http\Controllers\Controller;
use App\Modules\Users\Http\Requests\CreateUserRequest;
use App\Modules\Users\Http\Requests\UpdateUserRequest;
use App\Modules\Users\Http\Requests\UpdatePasswordRequest;
use App\Modules\Users\Http\Requests\UploadImageRequest;
use App\Modules\Users\Http\Requests\SearchRequest;

class UsersController extends Controller {

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		$this->middleware('auth');
	}

	/**
	 * Display a listing of users.
	 *
	 * @return Response
	 */
	public function index()
	{
		$users = User::orderBy('last_name')->paginate(10);
		return view('users::index', compact('users'));
	}

	/**
	 * Display a searched listing of users.
	 *
	 * @param  App\Modules\Users\Http\Requests\SearchRequest  $request
	 * @return Response
	 */
	public function search(SearchRequest $request)
	{	
		$query = $request->input('query');
		$users = User::search($query)->get();
		return view('users::search', compact('users'));
	}

	/**
	 * Show the form for creating a new user.
	 *
	 * @return Response
	 */
	public function create()
	{
		if (!user_can('create.users', true)) return redirect()->back();

		$result = Role::orderBy('name')->get();
		$roles = array();
		foreach ($result as $key) {
			$roles[$key->id] = $key->name;
		}
		return view('users::create', compact('roles'));
	}

	/**
	 * Store a newly created user in storage.
	 *
	 * @param  App\Modules\Users\Http\Requests\CreateUserRequest  $request
	 **/
	public function store(CreateUserRequest $request)
	{
		if (!user_can('create.users', true)) return redirect()->back()->withInput();
		$input = $request->all();
		$user = User::create($input);
		if ($request->has('role')) {
			$user->syncRoles([$input['role']]);
		}
		Mail::send('users::emails.welcome', $input, function($message) use ($input)
		{
		    $message->from(Auth::user()->email, Auth::user()->first_name.' '.Auth::user()->last_name);

		    $message->to($input['email']);

		    $message->subject('Welcome to '.config('appkit.app_name'));
		});
		return redirect()->route('users.index');
	}

	/**
	 * Display the specified user.
	 *
	 * @param  App\User  $user
	 * @return Response
	 */
	public function show(User $user)
	{
		if (!user_can('view.users', true, null, function($params) {
			return $params->id == Auth::user()->id ? true : false;
		}, $user)) return redirect()->back();

		return view('users::show', compact('user'));
	}

	/**
	 * Show the form for editing the specified user.
	 *
	 * @param  App\User  $user
	 * @return Response
	 */
	public function edit(User $user)
	{
		if (!user_can('edit.users', true, null, function($params) {
			return $params->id == Auth::user()->id ? true : false;
		}, $user)) return redirect()->back();

		$result = Role::orderBy('name')->get();
		$roles = array();
		foreach ($result as $key) {
			$roles[$key->id] = $key->name;
		}
		return view('users::edit', compact('user', 'roles'));
	}

	/**
	 * Update the specified user in storage.
	 *
	 * @param  App\User  $user
	 * @param  App\Modules\Users\Http\Requests\UpdateUserRequest  $request
	 * @return Response
	 */
	public function update(User $user, UpdateUserRequest $request)
	{
		if (!user_can('edit.users', true, null, function($params) {
			return $params->id == Auth::user()->id ? true : false;
		}, $user)) return redirect()->back()->withInput();

		$input = $request->all();
		if (!$request->has('is_superuser')){
			$input['is_superuser'] = false;
		}
		$user->update($input);
		if ($request->has('role')) {
			$user->syncRoles([$input['role']]);
		}
		flash()->success('User details successfully updated.');
		return redirect()->route('users.edit', $user->id);
	}

	/**
	 * Update the specified user's password.
	 *
	 * @param  App\User  $user
	 * @param  App\Modules\Users\Http\Requests\UpdatePasswordRequest  $request
	 * @return Response
	 */
	public function password(User $user, UpdatePasswordRequest $request)
	{
		$user->setPassword($request->input('password'));
		flash()->success('User password successfully updated.');
		return redirect()->route('users.edit', $user->id);
	}

	/**
	 * Upload the specified user's photo.
	 *
	 * @param  App\User  $user
	 * @param  App\Modules\Users\Http\Requests\UploadPhotoRequest  $request
	 * @return Response
	 */
	public function image(User $user, UploadImageRequest $request)
	{
		if ($request->hasFile('image'))
		{
		    $file = $request->file('image');
		    $userDir = sprintf('uploads/users/%s_%s', $user->key, $user->id);
		    $fileName = sprintf('%s.%s', str_random(21), $file->getClientOriginalExtension());
		    $path = sprintf('%s/%s', $userDir, $fileName);
		    $file->move(public_path($userDir), $fileName);
		    $user->update(['image' => $path]);
		    flash()->success('User photo successfully uploaded.');

		    return redirect()->route('users.edit', $user->id);
		}

		flash()->error('Whoops! No image was selected.');

		return redirect()->route('users.edit', $user->id);
	}

	/**
	 * Remove the specified user from storage.
	 *
	 * @param  App\User  $user
	 * @return Response
	 */
	public function destroy(User $user)
	{
		if (!user_can('delete.users', true)) return redirect()->route('users.index');

		$user->delete();
		flash()->success('User successfully deleted.');
		return redirect()->route('users.index');
	}

	/**
	 * Disable the specified user from storage.
	 *
	 * @param  App\User  $user
	 * @return Response
	 */
	public function disable(User $user)
	{
		if (!user_can('disable.users', true)) return redirect()->route('users.show', $user->id);

		$user->disable();
		flash('User disabled.');
		return redirect()->route('users.show', $user->id);
	}

	/**
	 * Enable the specified user from storage.
	 *
	 * @param  App\User  $user
	 * @return Response
	 */
	public function enable(User $user)
	{
		if (!user_can('enable.users', true)) return redirect()->route('users.show', $user->id);

		$user->enable();
		flash('User enabled.');
		return redirect()->route('users.show', $user->id);
	}

}