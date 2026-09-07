<?php

declare(strict_types=1);

session_start();

$config = require __DIR__ . '/../config/config.php';
define('BASE_URL', $config['base_url']);
date_default_timezone_set($config['timezone']);

require __DIR__ . '/../app/Core/Database.php';
require __DIR__ . '/../app/Core/Controller.php';
require __DIR__ . '/../app/Core/Router.php';
require __DIR__ . '/../app/Models/User.php';
require __DIR__ . '/../app/Models/Category.php';
require __DIR__ . '/../app/Models/Product.php';

$router = new Router();

$router->add('GET',  '/',                     'DashboardController@index');
$router->add('GET',  '/auth/login',           'AuthController@showLogin');
$router->add('POST', '/auth/login',           'AuthController@login');
$router->add('GET',  '/auth/logout',          'AuthController@logout');
$router->add('GET',  '/categories',           'CategoryController@index');
$router->add('GET',  '/categories/form',      'CategoryController@create');
$router->add('POST', '/categories/store',     'CategoryController@store');
$router->add('GET',  '/categories/edit/{id}', 'CategoryController@edit');
$router->add('POST', '/categories/update',    'CategoryController@update');
$router->add('POST', '/categories/delete',    'CategoryController@delete');
$router->add('GET',  '/products',             'ProductController@index');
$router->add('GET',  '/products/form',        'ProductController@create');
$router->add('POST', '/products/store',       'ProductController@store');
$router->add('GET',  '/products/edit/{id}',   'ProductController@edit');
$router->add('POST', '/products/update',      'ProductController@update');
$router->add('POST', '/products/delete',      'ProductController@delete');

$router->dispatch();