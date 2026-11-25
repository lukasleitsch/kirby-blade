<?php

use Leitsch\Blade\BladeDirectives;

it('renders a blade template with layout, snippet and escaped content', function () {
    // Act
    $html = $this->get('/')->body();

    // Assert
    expect($html)
        ->toContain('<main>')
        ->toContain('<h1>Tom &amp; &lt;b&gt;Jerry&lt;/b&gt;</h1>')
        ->toContain('<p>Hello Spike</p>');
});

it('renders plain php templates with kirby layout snippets', function () {
    // Act
    $html = $this->get('/plain')->body();

    // Assert
    expect($html)->toContain('<html><body><p>Plain rendered by PHP</p>');
});

it('renders anonymous and class based components', function () {
    // Act
    $html = $this->get('/components')->body();

    // Assert
    expect($html)
        ->toContain('<div class="alert alert-warning">Careful</div>')
        ->toContain('<button>SAVE</button>');
});

it('renders kirby helper and custom directives', function () {
    // Act
    $html = $this->get('/directives')->body();

    // Assert
    expect($html)
        ->toContain('<strong>bold</strong>')
        ->toContain('Hello Kirby')
        ->toContain('Please log in')
        ->not->toContain('Welcome back')
        ->not->toContain("\n");
});

it('maps every directive to an existing kirby helper', function () {
    // Act & Assert
    expect(BladeDirectives::HELPERS)->each->toBeCallable();
});

it('does not expose blade templates as content representation', function () {
    // Act & Assert
    expect($this->get('/home.blade')->code())->toBe(404);
});
