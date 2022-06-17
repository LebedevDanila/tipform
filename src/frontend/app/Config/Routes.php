<?php namespace Config;


// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (file_exists(SYSTEMPATH . 'Config/Routes.php'))
{
	require SYSTEMPATH . 'Config/Routes.php';
}

/**
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(true);

/**
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
/** Queue **/
$routes->cli('/queue/(:any)/(:any)', '\App\Queue\\\$1::$2');

$routes->add('/', 'Home::index');
$routes->add('/api', 'Home::api');

/* Custom Pages */
$routes->add('/privacy', 'Privacy::index');
$routes->add('/term-of-use', 'Agreement::index');

$routes->add('/contacts', 'Contacts::index');


/* Bundles */
$routes->add('/bundles/js/lib\.(:any)\.(:any)\.js', 'Bundles::js_lib/$1');
$routes->add('/bundles/js/(:any)\.(:any)\.js', 'Bundles::js/$1');
$routes->add('/bundles/css/(:any)\.(:any)\.css', 'Bundles::css/$1');

/* Sitemap */
/*$routes->add('/sitemap.xml', 'Sitemap::index');
$routes->add('/sitemaps/pages.xml', 'Sitemap::pages');
$routes->add('/sitemaps/articles.xml', 'Sitemap::articles');
$routes->add('/sitemaps/profiles-(:num).xml', 'Sitemap::profiles/$1');*/

/** Cron JOBS **/

/**
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (file_exists(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php'))
{
	require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
