<?php

return [

    'collections' => [

        'default' => [

            'info' => [
                'title' => env('OPENAPI_API_TITLE', 'Octools'),
                'description' => null,
                'version' => env('OPENAPI_API_VERSION', '0.0.1'),
                'contact' => [],
            ],

            'servers' => [
                [
                    'url' => env('OPENAPI_API_URL', env('APP_URL')),
                    'description' => null,
                    'variables' => [],
                ],
            ],

            'tags' => [
                 [
                    'name' => 'Application',
                 ],[
                    'name' => 'Member',
                 ],[
                    'name' => 'Organization',
                 ],[
                    'name' => 'Workspace',
                 ],[
                    'name' => 'User',
                 ],[
                    'name' => 'Github',
                 ],[
                    'name' => 'Gryzzly',
                 ],[
                    'name' => 'Slack',
                 ],
            ],

            'security' => [
                GoldSpecDigital\ObjectOrientedOAS\Objects\SecurityRequirement::create()
                    ->securityScheme('BearerToken'),
            ],

            // Non standard attributes used by code/doc generation tools can be added here
            'extensions' => [
                // 'x-tagGroups' => [
                //     [
                //         'name' => 'General',
                //         'tags' => [
                //             'user',
                //         ],
                //     ],
                // ],
            ],

            // Route for exposing specification.
            // Leave uri null to disable.
            'route' => [
                'uri' => '/openapi',
                'middleware' => [],
            ],

            // Register custom middlewares for different objects.
            'middlewares' => [
                'paths' => [
                    //
                ],
                'components' => [
                    //
                ],
            ],

        ],

    ],

    // Directories to use for locating OpenAPI object definitions.
    'locations' => [
        'callbacks' => [
            base_path('vendor/webid/octools/src/OpenApi/Callbacks'),
        ],

        'request_bodies' => [
            base_path('vendor/webid/octools/src/OpenApi/RequestBodies'),
            base_path('vendor/webid/octools-connectors/github/OpenApi/RequestBodies'),
            base_path('vendor/webid/octools-connectors/gryzzly/OpenApi/RequestBodies'),
            base_path('vendor/webid/octools-connectors/slack/OpenApi/RequestBodies'),
        ],

        'responses' => [
            base_path('vendor/webid/octools/src/OpenApi/Responses'),
            base_path('vendor/webid/octools-connectors/github/OpenApi/Responses'),
            base_path('vendor/webid/octools-connectors/gryzzly/OpenApi/Responses'),
            base_path('vendor/webid/octools-connectors/slack/OpenApi/Responses'),
        ],

        'schemas' => [
            base_path('vendor/webid/octools/src/OpenApi/Schemas'),
            base_path('vendor/webid/octools-connectors/github/OpenApi/Schemas'),
            base_path('vendor/webid/octools-connectors/gryzzly/OpenApi/Schemas'),
            base_path('vendor/webid/octools-connectors/slack/OpenApi/Schemas'),
        ],

        'security_schemes' => [
            base_path('vendor/webid/octools/src/OpenApi/SecuritySchemes'),
        ],
    ],

];
