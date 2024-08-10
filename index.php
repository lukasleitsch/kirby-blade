<?php

use Kirby\Cms\App as Kirby;
use Kirby\Template\Snippet as KirbySnippet;
use Leitsch\Blade\BladeDirectives;
use Leitsch\Blade\BladeFactory;
use Leitsch\Blade\BladeIfStatements;
use Leitsch\Blade\Paths;
use Leitsch\Blade\Snippet;
use Leitsch\Blade\Template;

@include_once __DIR__.'/vendor/autoload.php';

Kirby::plugin('leitsch/blade', [
    'options' => [
        'views' => function () {
            return kirby()->roots()->cache().'/views';
        },
        'directives' => [],
        'ifs' => [],
    ],
    'components' => [
        'template' => function (Kirby $kirby, string $name, ?string $contentType = null, ?string $defaultType = 'html') {
            return new Template($kirby, $name, $contentType, $defaultType);
        },
        'snippet' => function (Kirby $kirby, ?string $name, array $data = [], bool $slots = false): KirbySnippet|string {
            return (new Snippet($kirby, $name, $data, $slots))->load();
        },
    ],
    'hooks' => [
        'system.loadPlugins:after' => function () {
            BladeFactory::register([Paths::getPathTemplates()], Paths::getPathViews());
            BladeDirectives::register();
            BladeIfStatements::register();
        },
    ],
    'routes' => [
        [
            // Block all requests to /url.blade and return 404
            'pattern' => '(:all)\.blade',
            'action' => function ($all) {
                return false;
            },
        ],
    ],
]);
