<?php namespace Config;

use CodeIgniter\Config\BaseConfig;

class Filters extends BaseConfig
{
	// Makes reading things below nicer,
	// and simpler to change out script that's used.
	public $aliases = [
		'csrf'     => \CodeIgniter\Filters\CSRF::class,
		'toolbar'  => \CodeIgniter\Filters\DebugToolbar::class,
		'honeypot' => \CodeIgniter\Filters\Honeypot::class,
		'authApiKey'=> \App\Filters\AuthApiKey::class,
		// 'isLoggedIn' =>\App\Filters\IsLoggedIn::class,
		'isManager' => [
			\App\Filters\IsLoggedIn::class,
			\App\Filters\IsLoggedAsManager::class
		],
		'isGerant' => [
			\App\Filters\IsLoggedIn::class,
			\App\Filters\IsLoggedAsGerant::class
		],
		'isFacturier'=>[
			\App\Filters\IsLoggedIn::class,
			\App\Filters\IsLoggedAsFacturier::class
		],
		'isCaissier'=>[
			\App\Filters\IsLoggedIn::class,
			\App\Filters\IsLoggedAsCaissier::class
		],
		'isMagazinier'=>[
			\App\Filters\IsLoggedIn::class,
			\App\Filters\IsLoggedAsMagazinier::class
		]

		// 'isLoggedAsManager'=>\App\Filters\IsLoggedAsManager::class
	];

	// Always applied before every request
	public $globals = [
		'before' => [
			'csrf' =>['except' => 'api/v1/*']
		],
		'after'  => [
			'toolbar',
			//'honeypot'
		],
	];

	// Works on all of a particular HTTP method
	// (GET, POST, etc) as BEFORE filters only
	//     like: 'post' => ['CSRF', 'throttle'],
	public $methods = [];

	// List filter aliases and any before/after uri patterns
	// that they should run on, like:
	//    'isLoggedIn' => ['before' => ['account/*', 'profiles/*']],
	public $filters = [
		'authApiKey' => ['before' => ['api/v1/*']]
	];
}
