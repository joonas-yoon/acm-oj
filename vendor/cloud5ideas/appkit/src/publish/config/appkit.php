<?php

return [

	/*
	|--------------------------------------------------------------------------
	| Application Name
	|--------------------------------------------------------------------------
	|
	| Name of the AppKit application.
	|
	*/

	'app_name' => '{{name}}',

	/*
	|--------------------------------------------------------------------------
	| Ajaxify Application
	|--------------------------------------------------------------------------
	|
	| When set to 'true', AppKit will automatically perform ajax operations based on element 'data-*' attributes.
	| *** This is currently still in development and won't do anything if set to 'true'.
	|
	*/

	'ajaxify' => false,

	/*
	|--------------------------------------------------------------------------
	| Default Application Roles
	|--------------------------------------------------------------------------
	|
	| A list of roles to be seeded into the database.
	| Example: ['name' => 'Role Name', 'slug' => 'role.name', 'description' => 'Role description']
	|
	*/

	'default_roles' => [
		['name' => 'Administrator', 'slug' => 'app.admin', 'description' => 'Application administrator'],
		['name' => 'User', 'slug' => 'app.user', 'description' => 'Application user']
	],

	/*
	|--------------------------------------------------------------------------
	| Provide Registration
	|--------------------------------------------------------------------------
	|
	| Can guests register on this app.
	|
	*/

	'allow_registration' => true,

	/*
	|--------------------------------------------------------------------------
	| Show Page Not Found
	|--------------------------------------------------------------------------
	|
	| If 'can_register' is set to false, the CanRegister middleware will by default 
	| throw a 404 page not found. 
	| Set this to false if you want the middleware to redirect the user to the home page instead.
	|
	*/

	'register_404' => true,

	/*
	|--------------------------------------------------------------------------
	| Default Registration Role
	|--------------------------------------------------------------------------
	|
	| The default role to assign to registered users.
	|
	*/

	'register_role' => 'app.user',

	/*
	|--------------------------------------------------------------------------
	| Admin URL
	|--------------------------------------------------------------------------
	|
	| The url AppKit will use to render the url to the backend.
	| It can be a named route ('route'), a url ('url') or an action ('action').
	| To render the admin url, use the admin_url() helper function
	|
	*/

	'admin_url' => ['route' => 'admin'],

	/*
	|--------------------------------------------------------------------------
	| Access Denied Message
	|--------------------------------------------------------------------------
	|
	| The message that the Permission middleware will flash to the session should a user
	| not have the required permission to access a module.
	|
	*/

	'access_denied_message' => 'You do not have the required permission to access this module.',

	/*
	|--------------------------------------------------------------------------
	| Permission Denied Message
	|--------------------------------------------------------------------------
	|
	| The message that the 'user_can()' & 'user_is()' helper functions will flash to the session should a user
	| not have the required permission or role to perform an action.
	|
	*/

	'permission_denied_message' => 'You do not have the required permission for that action.',

	/*
    |--------------------------------------------------------------------------
    | View/s to Bind JavaScript Vars To
    |--------------------------------------------------------------------------
    |
    | Set this value to the name of the view (or partial) that
    | you want to prepend all JavaScript variables to.
    | This can be a single view, or an array of views.
    | Example: 'footer' or ['footer', 'bottom']
    |
    */
    'bind_js_vars_to_this_view' => 'shell::partials.scripts',

    /*
    |--------------------------------------------------------------------------
    | JavaScript Namespace
    |--------------------------------------------------------------------------
    |
    | By default, AppKit add variables to the appkit namespace. 
    | That way, you can access vars, like "appKit.someVariable."
    |
    */
    'js_namespace' => 'appKit',

	
	/*
	|--------------------------------------------------------------------------
	| !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
	|--------------------------------------------------------------------------
	|
	| Settings below this line, if changed could break AppKit.
	| If you change anything, please make sure to update your modules and composer.json file accordingly.
	|
	*/
	
	/*
	|--------------------------------------------------------------------------
	| Path to Modules
	|--------------------------------------------------------------------------
	|
	| Define the path where you'd like to store your modules. Note that if you
	| choose a path that's outside of your public directory, you will need to
	| copy your module assets (CSS, images, etc.) to your public directory.
	|
	*/

	'modules_path' => app_path('Modules'),

	/*
	|--------------------------------------------------------------------------
	| Modules Base Namespace
	|--------------------------------------------------------------------------
	|
	| Define the base namespace for your modules. Be sure to update this value
	| if you move your modules directory to a new path. This is primarily used
	| by the module:make Artisan command.
	|
	*/	

	'modules_namespace' => 'App\\Modules\\'
	
];
