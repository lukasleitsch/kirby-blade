<?php

namespace Leitsch\Blade;

use Exception;
use Illuminate\Support\Facades\View;
use Kirby\Cms\App;
use Kirby\Cms\Template as KirbyTemplate;
use Kirby\Filesystem\F;
use Kirby\Toolkit\Tpl;

class Template extends KirbyTemplate
{
    public const EXTENSION_BLADE = 'blade.php';
    public const EXTENSION_FALLBACK = 'php';

    protected string $templatesPath;
    protected string $viewsPath;
    protected ?string $extension = null;

    public function __construct(App $kirby, string $name, string $type = 'html', string $defaultType = 'html')
    {
        parent::__construct($name, $type, $defaultType);

        $this->templatesPath = Paths::getPathTemplates();
        $this->viewsPath = Paths::getPathViews();
    }

    public function render(array $data = []): string
    {
        if ($this->isBlade()) {
            View::share('kirby', $data['kirby']);
            View::share('site', $data['site']);
            View::share('pages', $data['pages']);
            View::share('page', $data['page']);

            $html = View::file($this->file(), $data)->render();
        } else {
            $html = Tpl::load($this->file(), $data);
        }

        return App::instance()->apply('blade.render:after', compact('html'), 'html');
    }

    public function isBlade(): bool
    {
        return $this->extension() === static::EXTENSION_BLADE;
    }

    public function extension(): string
    {
        if (! is_null($this->extension)) {
            // return from cache
            return $this->extension;
        }

        $filename = $this->file();

        return $this->extension = str_ends_with($filename, self::EXTENSION_BLADE) && file_exists($filename)
            ? static::EXTENSION_BLADE
            : static::EXTENSION_FALLBACK;
    }

    public function file(): ?string
    {
        // default type template (i.e. not a content representation)
        // Look for the default template provided by an extension.
        if ($this->hasDefaultType()) {
            $path = $this->getFilename($this->name());

            if ($path !== null) {
                return $path;
            }
        }

        // try to load content representation instead
        // disallow blade extension for content representation, for ex: /blog.blade
        if ($this->type() === 'blade') {
            return null;
        } else {
            $name = $this->name() . "." . $this->type();
        }

        return $this->getFilename($name);
    }

    public function getFilename(string $name): ?string
    {
        try {
            // Try the default blade template in the default template directory.
            return F::realpath("{$this->templatesPath}/{$name}." . self::EXTENSION_BLADE, $this->templatesPath);
        } catch (Exception) {
            // ignore errors, continue searching
        }

        try {
            // Try the default vanilla php template in the default template directory.
            return F::realpath("{$this->templatesPath}/{$name}." .  self::EXTENSION_FALLBACK, $this->templatesPath);
        } catch (Exception) {
            // ignore errors, continue searching
        }

        // Look for the template with type extension provided by an extension.
        // This might be null if the template does not exist.
        return App::instance()->extension($this->store(), $name);
    }
}
