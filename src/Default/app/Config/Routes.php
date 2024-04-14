<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->setAutoRoute(false);
$routes->set404Override();
// The Auto Routing (Legacy) is very dangerous. It is easy to create vulnerable apps
// where controller filters or CSRF protection are bypassed.
// If you don't want to define all routes, please use the Auto Routing (Improved).
// Set `$autoRoutesImproved` to true in `app/Config/Feature.php` and set the following to true.
//$routes->setAutoRoute(false);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
// foreach (\scanDirModule() as $key => $value) {
//     $configRoutes = pathModule().$value.'/Config/routes.php';
//     if(file_exists($configRoutes))
//     {
//     var_dump($configRoutes);
//         include $configRoutes;
//     }
// }
if(getenv('cineex.template.main')=='false')
{
    $routes->get('/', 'Dashboard\Home::index');
    $routes->get('/beranda', 'Dashboard\Home::index');
}
else
{
    $routes->get('/beranda', 'Home::index');
    $routes->get('/', 'Home::index');
}
$routes->get('/script/auth', 'Script::auth');
$routes->get('/dashboard', 'Dashboard\Home::index');
$routes->get('/dashboard/home', 'Dashboard\Home::index');

$routes->get('/dashboard/join', 'Dashboard\Join::index');

$routes->get('/dashboard/profil', 'Dashboard\Profil::index');
$routes->get('/dashboard/profil/index', 'Dashboard\Profil::index');
$routes->get('/dashboard/profil/setting', 'Dashboard\Profil::setting');

$routes->get('/dashboard/module', 'Dashboard\Module::index');
$routes->get('/dashboard/configweb', 'Dashboard\Configweb::index');
$routes->get('/dashboard/configemail', 'Dashboard\Configemail::index');

$routes->get('/dashboard/pengguna', 'Dashboard\Pengguna::index');
$routes->get('/dashboard/pengguna/form', 'Dashboard\Pengguna::form');
$routes->get('/dashboard/pengguna/form/(:any)', 'Dashboard\Pengguna::form/$1');

$routes->get('/dashboard/penggunalevel', 'Dashboard\Penggunalevel::index');
$routes->get('/dashboard/penggunalevel/form', 'Dashboard\Penggunalevel::form');
$routes->get('/dashboard/penggunalevel/form/(:any)', 'Dashboard\Penggunalevel::form/$1');

$routes->get('/dashboard/outbox', 'Dashboard\Outbox::index');
$routes->get('/dashboard/outbox/preview', 'Dashboard\Outbox::preview');
$routes->get('/dashboard/outbox/preview/(:any)', 'Dashboard\Outbox::preview/$1');

$routes->get('/auth', 'Dashboard\Auth::index');

$routes->get('/gis/overview', 'Gis::overview');

$routes->group('api',[], static function ($routes) {
    $routes->get('auth/user', 'Api\Auth::user');
    $routes->post('auth/signout', 'Api\Auth::signout');
    $routes->post('auth/signin', 'Api\Auth::signin');
    $routes->post('auth/signintest', 'Api\Auth::signintest');
    $routes->post('auth/signintest/(:any)', 'Api\Auth::signintest/$1');

    $routes->get('restful/data/(:any)', 'Api\Restful::data/$1');
    $routes->get('restful/nested/(:any)', 'Api\Restful::nested/$1');
    
    $routes->post('restful/create/(:any)', 'Api\Restful::create/$1');
    $routes->post('restful/upload/(:any)', 'Api\Restful::upload/$1');
    $routes->post('restful/upload/(:any)/(:any)', 'Api\Restful::upload/$1/$2');
    $routes->post('restful/importjson/(:any)', 'Api\Restful::importjson/$1');
    $routes->post('restful/base64image/(:any)', 'Api\Restful::base64image/$1');
    $routes->post('restful/base64image/(:any)/(:any)', 'Api\Restful::base64image/$1/$2');
    $routes->post('restful/createcsv', 'Api\Restful::createcsv');

    $routes->put('restful/update/(:any)', 'Api\Restful::update/$1');
    $routes->put('restful/updatenested/(:any)', 'Api\Restful::updatenested/$1');
    $routes->put('profil/update', 'Api\Profil::update');
    
    $routes->delete('restful/delete/(:any)', 'Api\Restful::delete/$1');

    $routes->put('pengguna/reset', 'Api\Pengguna::reset');

    //join
    $routes->get('join/module', 'Api\Join::module');
    $routes->get('join/value', 'Api\Join::value');

});

$routes->cli('cronjob/outbox', 'Cronjob::outbox');

$routes->get('/sitemap.xml', 'Sitemap::index');
/*
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
if (is_file(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
