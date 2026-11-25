<?php

return [
    'leitsch.blade.directives' => [
        'greeting' => fn (string $expression) => "<?php echo 'Hello '.{$expression} ?>",
    ],
    'leitsch.blade.ifs' => [
        'logged' => fn () => kirby()->user() !== null,
    ],
    'hooks' => [
        // minimal html minification, like the readme example
        'blade.render:after' => fn (string $html) => preg_replace('/\s+/', ' ', $html),
    ],
];
