<?php

namespace Leitsch\Blade;

use Illuminate\Support\Facades\Blade;

class BladeDirectives
{
    // Kirby helpers that are available as directives, e.g. @kirbytext($text)
    public const HELPERS = [
        'asset', 'attr', 'csrf', 'css', 'get', 'gist', 'h', 'html', 'image', 'js',
        'kirbytag', 'kirbytext', 'kirbytextinline', 'kt', 'kti', 'markdown', 'option',
        'param', 'size', 'smartypants', 'snippet', 'svg', 't', 'tc', 'timestamp', 'tt',
        'u', 'url', 'uuid', 'video', 'vimeo', 'widont', 'youtube',
    ];

    public static function register()
    {
        foreach (self::HELPERS as $helper) {
            Blade::directive($helper, fn (string $expression) => "<?php echo {$helper}({$expression}) ?>");
        }

        foreach (option('leitsch.blade.directives', []) as $directive => $callback) {
            Blade::directive($directive, $callback);
        }
    }
}
