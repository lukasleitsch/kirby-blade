<?php

use Kirby\Cms\App as Kirby;
use Kirby\Toolkit\A;
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
        'template' => function (Kirby $kirby, string $name, ?string $contentType = null) {
            return new Template($kirby, $name, $contentType);
        },
        'snippet' => function (Kirby $kirby, $name, array $data = []): ?string {
            return (new Snippet($kirby, $name, $data))->load();
        },
    ],
    'hooks' => [
        'system.loadPlugins:after' => function () {
            $componentModels = [];
            $componentNamespaces = [];
            $templatePaths = [];

            // stuff from other plugins
            foreach (kirby()->plugins() as $plugin) {
                $extends = $plugin->extends();
                $componentModels = array_merge($componentModels, array_flip(A::get($extends, 'blade.components', [])));
                $componentNamespaces = array_merge($componentNamespaces, A::get($extends, 'blade.namespaces', []));
                $templatePaths = array_merge($templatePaths, A::wrap(A::get($extends, 'blade.templates', [])));
            }

            BladeFactory::register(
                array_merge([Paths::getPathTemplates()], $templatePaths),
                Paths::getPathViews(),
                $componentModels,
                $componentNamespaces
            );
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
