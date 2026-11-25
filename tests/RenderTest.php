<?php

it('renders a blade template with layout, snippet and escaped content', function () {
    // Act
    $html = $this->get('/')->body();

    // Assert
    expect($html)
        ->toContain('<main>')
        ->toContain('<h1>Tom &amp; &lt;b&gt;Jerry&lt;/b&gt;</h1>')
        ->toContain('<p>Hello Spike</p>');
});

it('renders plain php templates', function () {
    // Act & Assert
    expect($this->get('/plain')->body())->toContain('<p>Plain rendered by PHP</p>');
});

it('renders anonymous and class based components', function () {
    // Act
    $html = $this->get('/components')->body();

    // Assert
    expect($html)
        ->toContain('<div class="alert alert-warning">Careful</div>')
        ->toContain('<button>SAVE</button>');
});
