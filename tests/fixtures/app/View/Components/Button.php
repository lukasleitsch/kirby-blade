<?php

namespace App\View\Components;

use Illuminate\Support\Facades\View;
use Illuminate\View\Component;

class Button extends Component
{
    public string $text;

    public function __construct(string $label)
    {
        $this->text = strtoupper($label);
    }

    public function render()
    {
        return View::make('components.button');
    }
}
