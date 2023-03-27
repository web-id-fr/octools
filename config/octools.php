<?php

use Webid\Octools\Nova\Application;
use Webid\Octools\Nova\Dashboards\Main;
use Webid\Octools\Nova\Member;
use Webid\Octools\Nova\Organization;
use Webid\Octools\Nova\User;
use Webid\Octools\Nova\Workspace;

return [
    /*
    |--------------------------------------------------------------------------
    | Models
    |--------------------------------------------------------------------------
    |
    | This array defines model classes. Feel free to extend with your own models.
    |
    */

    'models' => [
        'user' => App\Models\User::class,
        'member' => \Webid\Octools\Models\Member::class,
        'application' => \Webid\Octools\Models\Application::class,
        'member_service' => \Webid\Octools\Models\MemberService::class,
        'organization' => \Webid\Octools\Models\Organization::class,
        'workspace' => \Webid\Octools\Models\Workspace::class,
        'workspace_service' => \Webid\Octools\Models\WorkspaceService::class,
    ],

    'routing' => [
        'prefix' => 'api',

        'middlewares' => [
            'auth:api',
        ],
    ],

    'nova' => [
        'dashboard_class' => Main::class,

        'menus' => [
            Organization::class => 'library',
            User::class => 'user-circle',
            Workspace::class => 'collection',
            Application::class => 'finger-print',
            Member::class => 'users',
        ],

        'overrides' => [

            /*
            |--------------------------------------------------------------------------
            | Branding
            |--------------------------------------------------------------------------
            |
            | These configuration values allow you to customize the branding of the
            | Nova interface, including the primary color and the logo that will
            | be displayed within the Nova interface. This logo value must be
            | the absolute path to an SVG logo within the local filesystem.
            |
            */

            'brand' => [
                'logo' => public_path('vendor/octools/Octools_logo_text.svg'),

                'colors' => [
                    "400" => "106, 53, 255, 0.5",
                    "500" => "106, 53, 255",
                    "600" => "106, 53, 255, 0.75",
                ]
            ],
        ],
    ],
];
