<?php

use Kirby\Cms\App;
use Tests\TestCase;

App::$enableWhoops = false;

pest()->extend(TestCase::class)->in(__DIR__);
