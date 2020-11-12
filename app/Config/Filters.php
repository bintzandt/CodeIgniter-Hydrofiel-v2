<?php
namespace Config;

use App\Filters\IsAdmin;
use App\Filters\IsAdminOrRequestedUser;
use App\Filters\IsLoggedIn;
use CodeIgniter\Config\BaseConfig;
use CodeIgniter\Filters\CSRF;
use CodeIgniter\Filters\DebugToolbar;

class Filters extends BaseConfig
{
    // Makes reading things below nicer,
    // and simpler to change out script that's used.
    public $aliases = [
        'csrf' => CSRF::class,
        'toolbar' => DebugToolbar::class,
        'honeypot' => \CodeIgniter\Filters\Honeypot::class,
        'isLoggedIn' => IsLoggedIn::class,
        'isAdmin' => [
            IsLoggedIn::class,
            IsAdmin::class,
        ],
        'isAdminOrRequestedUser' => [
            IsLoggedIn::class,
            IsAdminOrRequestedUser::class,
        ],
    ];

    // Always applied before every request
    public $globals = [
        'before' => [
            //'honeypot'
            // 'csrf',
        ],
        'after' => [
            'toolbar',
            //'honeypot'
        ],
    ];

    // Works on all of a particular HTTP method
    // (GET, POST, etc) as BEFORE filters only
    //     like: 'post' => ['CSRF', 'throttle'],
    public $methods = [
        // 'post' => ['csrf'],
    ];

    // List filter aliases and any before/after uri patterns
    // that they should run on, like:
    //    'isLoggedIn' => ['before' => ['account/*', 'profiles/*']],
    public $filters = [
        'isLoggedIn' => ['before' => ['user', 'user/*', 'event', 'event/*', 'training']],
        'isAdmin' => ['before' => ['admin/*']],
        'isAdminOrRequestedUser' => ['before' => ['user/edit/*']]
    ];
}
