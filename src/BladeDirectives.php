<?php

namespace Leitsch\Blade;

use Illuminate\Support\Facades\Blade;

class BladeDirectives
{
    public static function register()
    {
        Blade::directive('asset', function (string $expression) {
            return "<?php echo asset({$expression})) ?>";
        });

        Blade::directive('attr', function (string $expression) {
            return "<?php echo attr({$expression})) ?>";
        });

        Blade::directive('csrf', function (string $expression) {
            if (strlen($expression) === 0) {
                return "<?php echo csrf() ?>";
            }

            return "<?php echo csrf({$expression}) ?>";
        });

        Blade::directive('css', function (string $expression) {
            return "<?php echo css({$expression}) ?>";
        });

        Blade::directive('get', function (string $expression) {
            return "<?php echo get({$expression}) ?>";
        });

        Blade::directive('gist', function (string $expression) {
            return "<?php echo gist({$expression}) ?>";
        });

        Blade::directive('h', function (string $expression) {
            return "<?php echo h({$expression}) ?>";
        });

        Blade::directive('html', function (string $expression) {
            return "<?php echo html({$expression}) ?>";
        });

        Blade::directive('js', function (string $expression) {
            return "<?php echo js({$expression}) ?>";
        });

        Blade::directive('image', function (string $expression) {
            return "<?php echo image({$expression}) ?>";
        });

        Blade::directive('kirbytag', function (string $expression) {
            return "<?php echo kirbytag($expression) ?>";
        });

        Blade::directive('kirbytext', function (string $expression) {
            return "<?php echo kirbytext($expression) ?>";
        });

        Blade::directive('kirbytextinline', function (string $expression) {
            return "<?php echo kirbytextinline($expression) ?>";
        });

        Blade::directive('kt', function (string $expression) {
            return "<?php echo kt({$expression}) ?>";
        });

        Blade::directive('kti', function (string $expression) {
            return "<?php echo kti({$expression}) ?>";
        });

        Blade::directive('markdown', function (string $expression) {
            return "<?php echo markdown({$expression}) ?>";
        });

        Blade::directive('option', function (string $expression) {
            return "<?php echo option({$expression}) ?>";
        });

        Blade::directive('param', function (string $expression) {
            return "<?php echo param({$expression}) ?>";
        });

        Blade::directive('size', function (mixed $expression) {
            return "<?php echo size({$expression}) ?>";
        });

        Blade::directive('smartypants', function (string $expression) {
            return "<?php echo smartypants({$expression}) ?>";
        });

        Blade::directive('snippet', function (string $expression) {
            return "<?php echo snippet({$expression}) ?>";
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

        Blade::directive('timestamp', function (string $expression) {
            return "<?php echo timestamp({$expression}) ?>";
        });

        Blade::directive('tt', function (string $expression) {
            return "<?php echo tt({$expression}) ?>";
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

        Blade::directive('uuid', function () {
            return "<?php echo uuid() ?>";
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

        foreach (option('leitsch.blade.directives', []) as $directive => $callback) {
            Blade::directive($directive, $callback);
        }
    }
}
