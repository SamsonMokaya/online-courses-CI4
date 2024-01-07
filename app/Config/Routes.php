<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
// $routes->get('/', 'Home::index');
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Users');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(false);


/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

$routes->get('/', 'Users::index');
$routes->get('/signup', 'Users::signUp');
$routes->get('/signin', 'Users::signIn');
$routes->get('/token', 'Users::sendResetToken');
$routes->get('/reset', 'Users::resetPassword');
$routes->post('/signIn', 'Users::signInUser');
$routes->get('/register', 'Users::registerUser');
$routes->post('/register', 'Users::registerUser');
$routes->get('/logout', 'Users::logout');
$routes->post('/subscribe-payment', 'Users::processPayment');