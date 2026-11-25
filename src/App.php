<?php

namespace Leitsch\Blade;

use Illuminate\Container\Container;
use Illuminate\Contracts\Foundation\Application;

class App extends Container
{
    /**
     * @see Application::getNamespace()
     */
    public function getNamespace(): string
    {
        return 'App\\';
    }
}
