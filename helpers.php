<?php

use Illuminate\Support\Facades\View;
use Illuminate\Support\Str;
use Illuminate\View\ComponentAttributeBag;

/**
 * Render a blade component.
 * @param string $name Component name, exclude component folder (i.e use "card" instead of "components.card")
 * @param array $props Component properties
 * @param array $attributes Component attributes
 * @return \Illuminate\Contracts\View\View
 */
if (! function_exists('component')) {
    function component($name, $props = [], $attributes = [])
    {
        $className = collect(explode('.', $name))->map(fn($part) => Str::studly($part))->join('\\');
        $className = "App\\View\\Components\\{$className}";

        if (class_exists($className)) {
            $reflection = (new \ReflectionClass($className))->getConstructor();
            $parameters = [];
            foreach ($reflection->getParameters() as $param) {
                $parameters[] = $props[$param->name] ?? $param->getDefaultValue();
            }
            $component = new $className(...$parameters);
            $component->withAttributes($attributes);

            return $component->render()->with($component->data());
        }

        $props['attributes'] = new ComponentAttributeBag($attributes);

        return View::make("components.{$name}", $props);
    }
}
