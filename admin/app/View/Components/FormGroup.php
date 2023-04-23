<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class FormGroup extends Component
{
    public $name;
    public $label;
    public $type;
    public $fullwidth;
    public $required;
    public $value;
    public $options;
    /**
     * Create a new component instance.
     */
    public function __construct(string $name, string $label, string $type = 'text', bool $fullwidth = false, bool $required = false, $value = '', array $options = [])
    {
        $this->name = $name;
        $this->label = $label;
        $this->type = $type;
        $this->fullwidth = $fullwidth;
        $this->required = $required;
        $this->value = $value;
        $this->options = $options;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.form-group');
    }
}
