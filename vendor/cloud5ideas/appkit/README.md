> This project is no longer being developed. I am currently in the process of developing a new package. Feel free however to still use this package or do with it what you want.

## Cloud5 Idea Studio : Laravel 5 AppKit

[![Laravel](https://img.shields.io/badge/Laravel-5.0-orange.svg?style=flat-square)](http://laravel.com)
![Release](https://img.shields.io/badge/release-beta-orange.svg?style=flat-square)
![Stability](https://img.shields.io/badge/stability-stable-green.svg?style=flat-square)
[![License](http://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](https://tldrlegal.com/license/mit-license)

---

AppKit is a collection of projects that provide tools and utilities for building modular Laravel 5 applications.

It comes with an authentication, shell and user management module out of the box, allowing you to dive right into building your own modules to expand your application.

Each module is completely self-contained allowing the ability to simply drop a module in for use.

AppKit also provides simple **roles** and **permissions** allowing you to specify which users of your application can access what modules or functions.
By using AppKit's middleware, you can easily protect routes and controller functions from unauthorized users.

AppKit uses the module permissions to render the [navigation](https://github.com/Cloud5Ideas/appkit/wiki/Module-Navigation) of the application for you, without you having to do anything, except set a few properties in a 
[`module.json`](https://github.com/Cloud5Ideas/appkit/wiki/module.json) file.

The package follows the FIG standards PSR-1, PSR-2, and PSR-4 to ensure a high level of interoperability between shared PHP code. At the moment the package is not unit tested, but is planned to be covered later down the road.

---

Documentation
-------------
For more information and how to use AppKit: Read the [Documentation Wiki](https://github.com/Cloud5Ideas/appkit/wiki)

---

Quick Installation
------------------
I recommend you use AppKit with a fresh Laravel 5 project, as it updates the default migration, routes and kernal files.

Before you start, if you haven't already, run the `npm install` command in your Laravel project's root directory. AppKit's assets require gulp to be installed and upon initialization, AppKit will execute the `gulp` command to compile its assets.

Once NPM has completed, install the package through Composer. The best way to do this is through your terminal via Composer itself:

```
composer require cloud5ideas/appkit:dev-master
```

Once this operation is complete, simply add the service provider to your project's `config/app.php` file:

#### Service Provider
```
'C5\AppKit\AppKitServiceProvider',
```

#### Initialize
Now run the following **Artisan** command to initialize AppKit.

```
php artisan appkit:init [name] [assets]
```

Replace `[name]` with the name of your application - **Required**

Replace `[assets]` with either `less` if you'd like to use the less assets or `sass` if you'd like to use the sass assets - **Required**

That's it! Now you you can expand your application and build something amazing.

#### Install
Before you run or serve your new application, run the following **Artisan** command:
```
php artisan appkit:install
```
This command will run all application and module migrations, seed the database and create a super user. This command will also ask if you would like optimize (`php artisan optimize`) and to serve (`php artisan serve`) the application. Type yes if you'd like to, otherwise type no.

---

#### Contributing

If you would like to contribute to AppKit, this is [how to](https://github.com/Cloud5Ideas/appkit/wiki/Contributing).

#### Issues, Suggestions, Enhancements...

To log any bugs, provide suggestions or enhancements etc. please follow [this guide](https://github.com/Cloud5Ideas/appkit/wiki/Issues).

---

#### Credits

AppKit is made up of a few projects, and I have [these people](https://github.com/Cloud5Ideas/appkit/wiki/Some-Love) to thank for their hard work and making their projects available to us.
