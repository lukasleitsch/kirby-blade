<?php

namespace Tests;

use Kirby\Cms\App;
use Kirby\Cms\Response;
use Kirby\Filesystem\Dir;
use PHPUnit\Framework\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    protected App $kirby;

    protected function setUp(): void
    {
        parent::setUp();

        // App::destroy() also unregisters plugins
        if (App::plugin('leitsch/blade') === null) {
            require __DIR__.'/../index.php';
        }

        $this->kirby = new App([
            'roots' => [
                'index' => __DIR__.'/fixtures',
                'cache' => $this->cacheRoot(),
            ],
        ]);
    }

    protected function tearDown(): void
    {
        App::destroy();
        Dir::remove($this->cacheRoot());

        parent::tearDown();
    }

    protected function get(string $path): Response
    {
        return $this->kirby->render($path);
    }

    private function cacheRoot(): string
    {
        return __DIR__.'/tmp';
    }
}
