<?php

namespace Leitsch\Blade;

use Illuminate\Config\Repository;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Events\Dispatcher;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\Facade;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Str;
use Illuminate\View\Compilers\BladeCompiler;
use Illuminate\View\DynamicComponent;
use Illuminate\View\Engines\CompilerEngine;
use Illuminate\View\Engines\EngineResolver;
use Illuminate\View\FileViewFinder;

class BladeFactory
{
    public static function register(array $pathsToTemplates, string $pathToCompiledTemplates)
    {
        $container = App::getInstance();

        // we have to bind our app class to the interface
        // as the blade compiler needs the `getNamespace()` method to guess Blade component FQCNs
        $container->instance(Application::class, $container);

        // Dependencies
        $filesystem = new Filesystem;
        $eventDispatcher = new Dispatcher($container);

        // Create View Factory capable of rendering PHP and Blade templates
        $viewResolver = new EngineResolver;
        $bladeCompiler = new BladeCompiler($filesystem, $pathToCompiledTemplates);

        $viewResolver->register('blade', fn () => new CompilerEngine($bladeCompiler));

        $viewFinder = new FileViewFinder($filesystem, $pathsToTemplates);
        $viewFactory = new \Illuminate\View\Factory($viewResolver, $viewFinder, $eventDispatcher);
        $viewFactory->setContainer($container);
        Facade::setFacadeApplication($container);
        $container->instance(Factory::class, $viewFactory);
        $container->alias(
            Factory::class,
            (new class extends View
            {
                public static function getFacadeAccessor()
                {
                    return parent::getFacadeAccessor();
                }
            })::getFacadeAccessor()
        );
        $container->instance(BladeCompiler::class, $bladeCompiler);
        $container->alias(
            BladeCompiler::class,
            (new class extends \Illuminate\Support\Facades\Blade
            {
                public static function getFacadeAccessor()
                {
                    return parent::getFacadeAccessor();
                }
            })::getFacadeAccessor()
        );

        $config = new Repository;
        $config->set('view.compiled', $pathToCompiledTemplates);
        $container['config'] = $config;

        $bladeCompiler->component('dynamic-component', DynamicComponent::class);

        // Use Kirby’s internal uuid() helper function instead of
        // ramsey/uuid to avoid installation of several additional
        // dependencies.
        Str::createUuidsUsing('uuid');
    }
}
