<?php

namespace Leitsch\Blade;

use Illuminate\Support\Facades\Blade;

class BladeDirectives
{
    public static function register()
    {
        Blade::directive('asset', function (string $expression) {
            return "<?php echo (new \\Kirby\\Cms\\Asset({$expression})) ?>";
        });

        Blade::directive('csrf', function (string $expression) {
            if (strlen($expression) === 0) {
                return "<?php echo \\Kirby\\Cms\\App::instance()->csrf() ?>";
            }

            return "<?php echo \\Kirby\\Cms\\App::instance()->csrf({$expression}) ?>";
        });

        Blade::directive('css', function (string $expression) {
            return "<?php echo \\Kirby\\Cms\\Html::css({$expression}) ?>";
        });

        Blade::directive('get', function (string $expression) {
            return "<?php echo \\Kirby\\Cms\\App::instance()->request()->get({$expression}) ?>";
        });

        Blade::directive('gist', function (string $expression) {
            return
                "<?php \$args = [$expression]; \$params = ['gist' => \$args[0]]; " .
                "if (isset(\$args[1])) \$params['file'] = \$args[1];" .
                "echo \\Kirby\\Cms\\App::instance()->kirbytag(\$params) ?>";
        });

        Blade::directive('h', function (string $expression) {
            return "<?php echo \\Kirby\\Cms\\Html::encode({$expression}) ?>";
        });

        Blade::directive('html', function (string $expression) {
            return "<?php echo \\Kirby\\Cms\\Html::encode({$expression}) ?>";
        });

        Blade::directive('js', function (string $expression) {
            return "<?php echo \\Kirby\\Cms\\Html::js({$expression}) ?>";
        });

        Blade::directive('image', function (string $expression) {
            return "<?php echo \\Kirby\\Cms\\App::instance()->image({$expression}) ?>";
        });

        Blade::directive('kirbytag', function (string $expression) {
            return "<?php echo \\Kirby\\Cms\\App::instance()->kirbytag($expression) ?>";
        });

        Blade::directive('kirbytext', function (string $expression) {
            return "<?php echo \\Kirby\\Cms\\App::instance()->kirbytext($expression) ?>";
        });

        Blade::directive('kirbytextinline', function (string $expression) {
            return
                "<?php \$args = [$expression]; " .
                "if(! isset(\$args[1]) || ! is_array(\$args[1])) \$args[1] = []; " .
                "if(! isset(\$args[1]['markdown']) || ! is_array(\$args[1]['markdown'])) \$args[1]['markdown'] = []; " .
                "\$args[1]['markdown']['inline'] = true; " .
                "echo \\Kirby\\Cms\\App::instance()->kirbytext(...\$args); ?>";
        });

        Blade::directive('kt', function (string $expression) {
            return "<?php echo \\Kirby\\Cms\\App::instance()->kirbytext({$expression}) ?>";
        });

        Blade::directive('markdown', function (string $expression) {
            return "<?php echo \\Kirby\\Cms\\App::instance()->markdonw({$expression}) ?>";
        });

        Blade::directive('option', function (string $expression) {
            return "<?php echo \\Kirby\\Cms\\App::instance()->option({$expression}) ?>";
        });


        Blade::directive('param', function (string $expression) {
            return "<?php echo \\Kirby\\Cms\\App::instance()->param({$expression}) ?>";
        });

        Blade::directive('size', function (mixed $expression) {
            return "<?php echo \\Kirby\\Cms\\Helpers::size({$expression}) ?>";
        });

        Blade::directive('smartypants', function (string $expression) {
            return "<?php echo \\Kirby\\Cms\\App::instance()->smartypants({$expression}) ?>";
        });

        Blade::directive('snippet', function (string $expression) {
            return "<?php snippet({$expression}) ?>";
        });

        Blade::directive('svg', function (string $expression) {
            return "<?php echo svg({$expression}) ?>";
        });

        Blade::directive('t', function (string $expression) {
            return "<?php echo t({$expression}) ?>";
        });

        Blade::directive('tc', function (string $expression) {
            return "<?php echo tc({$expression}) ?>";
        });

        Blade::directive('twitter', function (string $expression) {
            return "<?php echo twitter({$expression}) ?>";
        });

        Blade::directive('u', function (string $expression) {
            return "<?php echo u({$expression}) ?>";
        });

        Blade::directive('url', function (string $expression) {
            return "<?php echo url({$expression}) ?>";
        });

        Blade::directive('video', function (string $expression) {
            return "<?php echo video({$expression}) ?>";
        });

        Blade::directive('vimeo', function (string $expression) {
            return "<?php echo vimeo({$expression}) ?>";
        });

        Blade::directive('widont', function (string $expression) {
            return "<?php echo widont({$expression}) ?>";
        });

        Blade::directive('youtube', function (string $expression) {
            return "<?php echo youtube({$expression}) ?>";
        });

        foreach ($directives = option('leitsch.blade.directives', []) as $directive => $callback) {
            Blade::directive($directive, $callback);
        }
    }
}
