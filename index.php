<?php

use Afbora\Template;
use Kirby\Cms\App as Kirby;

@include_once __DIR__ . '/vendor/autoload.php';

Kirby::plugin('afbora/blade', [
    'options' => [
        'views' => function () {
            return kirby()->roots()->cache() . '/views';
        },
        'directives' => [],
        'ifs' => [],
        'minify' => [
            'enabled' => false,
            'options' => [],
        ]
    ],
    'components' => [
        'template' => function (Kirby $kirby, string $name, string $contentType = null) {
            return new Template($kirby, $name, $contentType);
        }
    ],
    'routes' => [
        [
            // Block all requests to /url.blade and return 404
            'pattern' => '(:all)\.blade',
            'action' => function ($all) {
                return false;
            }
        ]
    ]
]);
