<?php
/**
 * Routes configuration
 *
 * In this file, you set up routes to your controllers and their actions.
 * Routes are very important mechanism that allows you to freely connect
 * different urls to chosen controllers and their actions (functions).
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2011, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2011, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Config
 * @since         CakePHP(tm) v 0.2.9
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

	Router::connect('/', array('controller' => 'products', 'action' => 'index'));
    Router::connect('/SocialRegister', array('controller' => 'users', 'action' => 'SocialRegister'));
	Router::connect('/u/:slug/*', array('controller' => 'users', 'action' => 'profile'), array('pass' => array('slug')));
	Router::connect('/product/:slug', array('controller' => 'products', 'action' => 'view'), array('pass' => array('slug')));

	Router::connect('/brand/:slug', array('controller' => 'brands', 'action' => 'view'), array('pass' => array('slug')));

	Router::connect('/category/:slug', array('controller' => 'categories', 'action' => 'view'), array('pass' => array('slug')));
    
	Router::connect('/sitemap.xml', array('controller' => 'products', 'action' => 'sitemap'));

	Router::connect('/admin', array('controller' => 'orders', 'action' => 'index', 'admin' => true));
	Router::connect('/customer', array('controller' => 'users', 'action' => 'dashboard', 'customer' => true));

	//Router::connect('/products/term_and_conditions', array('controller' => 'products', 'action' => 'term', 'admin' => false));
    Router::connect('/updatePassword/*', array('controller' => 'users', 'action' => 'updatePassword'));
	Router::connect('/register', array('controller' => 'users', 'action' => 'register'));
	Router::connect('/howitworks', array('controller' => 'products', 'action' => 'howitworks'));
	Router::connect('/instruction', array('controller' => 'products', 'action' => 'instruction'));
	Router::connect('/logout', array('controller' => 'users', 'action' => 'logout'));
	Router::connect('/carts', array('controller' => 'orders', 'action' => 'carts'));
	Router::connect('/ourstory', array('controller' => 'products', 'action' => 'ourstory'));
	Router::connect('/contact', array('controller' => 'products', 'action' => 'contact'));
	Router::connect('/help', array('controller' => 'products', 'action' => 'help'));
	Router::connect('/privacypolicy', array('controller' => 'products', 'action' => 'privacypolicy'));
	Router::connect('/term_and_conditions', array('controller' => 'products', 'action' => 'term'));

/**
 * ...and connect the rest of 'Pages' controller's urls.
 */
	Router::connect('/pages/*', array('controller' => 'pages', 'action' => 'display'));

/**
 * Load all plugin routes.  See the CakePlugin documentation on
 * how to customize the loading of plugin routes.
 */
	CakePlugin::routes();

/**
 * Load the CakePHP default routes. Remove this if you do not want to use
 * the built-in default routes.
 */
	require CAKE . 'Config' . DS . 'routes.php';

