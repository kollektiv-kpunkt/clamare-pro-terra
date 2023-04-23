<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class ButtonLink extends Component
{
    public string $href;
    public string $method;
    /**
     * Create a new component instance.
     */
    public function __construct($href, $method = 'GET')
    {
        $this->href = $href;
        $this->method = $method;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.button-link');
    }
}
