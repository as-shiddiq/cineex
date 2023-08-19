<?php

namespace Config;
// use Cineex\Cineex;
use CodeIgniter\Config\BaseConfig;
use CodeIgniter\Filters\CSRF;
use CodeIgniter\Filters\DebugToolbar;
use CodeIgniter\Filters\Honeypot;
use CodeIgniter\Filters\InvalidChars;
use CodeIgniter\Filters\SecureHeaders;

$db = new \App\Models\PenggunaModel;

// $cineex = new Cineex();
// foreach ($cineex->scanDirModule() as $key => $value) {
//     $filter = $cineex->pathModule().$value.'/Config/Filters.php';
//     if(file_exists($filter))
//     {
//         include $filter;
//         $exceptAuth = array_merge($exceptAuthAdd,$exceptAuth);
//         unset($exceptAuthAdd);
//     }
// }
define('exceptAuth', $exceptAuth);

class Filters extends BaseConfig
{
    /**
     * Configures aliases for Filter classes to
     * make reading things nicer and simpler.
     *
     * @var array
     */
    public $aliases = [
        'csrf'          => CSRF::class,
        'toolbar'       => DebugToolbar::class,
        'honeypot'      => Honeypot::class,
        'invalidchars'  => InvalidChars::class,
        'secureheaders' => SecureHeaders::class,
        'auth'          => \App\Filters\AuthFilter::class,
        'cors'          => \App\Filters\CorsFilter::class,
    ];

    /**
     * List of filter aliases that are always
     * applied before and after every request.
     *
     * @var array
     */
    public $globals = [
        'before' => [
            'auth' => ['except' => [ 
                'auth',
                'auth/*',
                'api/auth',
                'api/auth/*', 
                'sitemap.xml',
                'beranda',
                'cronjob/outbox'
                // '/'
            ]],
            'cors'
            // 'honeypot',
            // 'csrf',
            // 'invalidchars',
        ],
        'after' => [
            // 'toolbar',
            // 'honeypot',
            // 'secureheaders',
        ],
    ];

    /**
     * List of filter aliases that works on a
     * particular HTTP method (GET, POST, etc.).
     *
     * Example:
     * 'post' => ['foo', 'bar']
     *
     * If you use this, you should disable auto-routing because auto-routing
     * permits any HTTP method to access a controller. Accessing the controller
     * with a method you don’t expect could bypass the filter.
     *
     * @var array
     */
    public $methods = [];

    /**
     * List of filter aliases that should run on any
     * before or after URI patterns.
     *
     * Example:
     * 'isLoggedIn' => ['before' => ['account/*', 'profiles/*']]
     *
     * @var array
     */
    public $filters = [];
}
