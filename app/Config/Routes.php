<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->setDefaultNamespace('App\Controllers\Admin\Dashboard');
$routes->setDefaultController('Dashboard');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(true);

 $routes->group('admin', function($routes){
    $routes->get('/', 'Dashboard::index', ['namespace' => 'App\Controllers\Admin\Dashboard']);
	$routes->get('dashboard', 'Dashboard::index', ['namespace' => 'App\Controllers\Admin\Dashboard']);

	$routes->group('auth', function ($routes) {
		$routes->get('login', 'Login::index', ['namespace' => 'App\Controllers\Admin\Auth']);
		$routes->post('savetoken', 'Login::savetoken', ['namespace' => 'App\Controllers\Admin\Auth']);
		$routes->post('login', 'Login::login', ['namespace' => 'App\Controllers\Admin\Auth']);
		$routes->post('logout', 'Login::logout', ['namespace' => 'App\Controllers\Admin\Auth']);
	});

	$routes->group('provider', function ($routes) {
		$routes->get('/', 'Provider::index', ['namespace' => 'App\Controllers\Admin\Provider']);
		$routes->post('create', 'Banner::create', ['namespace' => 'App\Controllers\Admin\Banner']);
		$routes->post('update/(:segment)', 'Banner::update/$1', ['namespace' => 'App\Controllers\Admin\Banner']);
		$routes->post('delete', 'Banner::delete', ['namespace' => 'App\Controllers\Admin\Banner']);
	});

	$routes->group('contact', function($routes){
		$routes->get('/', 'Contact::index', ['namespace' => 'App\Controllers\Admin\Contact']);
		$routes->post('create', 'Contact::create', ['namespace' => 'App\Controllers\Admin\Contact']);
		$routes->post('update/(:segment)', 'Contact::update/$1', ['namespace' => 'App\Controllers\Admin\Contact']);
		$routes->post('delete', 'Contact::delete', ['namespace' => 'App\Controllers\Admin\Contact']);
	});
});
